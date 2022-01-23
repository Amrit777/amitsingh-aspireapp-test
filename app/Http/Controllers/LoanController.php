<?php

namespace App\Http\Controllers;

use App\Constant\Constants;
use App\Http\Resources\LoanResource;
use App\Models\Loan;
use App\Models\LoanRepayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Matcher\Contains;
use Nette\Schema\Context;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $limit = $request->limit;
        $limit = ($limit) ? $limit : Constants::PAGINATION_COUNT;
        $list = Loan::latest('id');
        if ($user->isAdmin()) {
            if ($request->filled('user_id')) {
                $list->where('user_id', $request->user_id);
            }
        }
        if ($user->isUser()) {
            $list->where('user_id', $user->id);
        }
        if ($request->filled('state_id')) {
            $list->where('state_id', $request->state_id);
        }

        $list = $list->paginate($limit);
        return $this->success(
            [
                'data' => LoanResource::collection($list),
                'message' => 'Loan List fetched successfully'
            ]
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'loan_amount_required' => 'required|numeric|gt:1',
            'user_monthly_earnings' =>  'required|numeric|gt:1',
            'loan_term' => 'required|numeric|gt:1'
        ]);
        try {
            DB::beginTransaction();
            $request['user_id'] = Auth::user()->id;
            $request['state_id'] = Constants::LOAN_PROCESSING;
            $model = Loan::create($request->all());
            DB::commit();
            return $this->success([
                'data' => new LoanResource($model),
                'message' => 'Loan Application stored successfully.'
            ]);
        } catch (\Illuminate\Database\QueryException $exception) {
            DB::rollback();
            return $this->error($exception->errorInfo);
        }
    }

    public function changeStatusAdmin(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
            'state_id' => 'required|numeric'
        ]);
        $model = Loan::findOrFail($request->id);
        if ($request->state_id == $model->state_id) {
            return $this->failed("This loan application is already in the marked state.");
        }
        try {
            DB::beginTransaction();
            if ($request->state_id == Constants::LOAN_ADMIN_APPROVE) {
                $model->amount_sactioned_date = Carbon::now()->toDateTimeString();
                // weekly repayment amount = loan_amount_required/loan term
                $weeklyRepaymentAmount = round(($model->loan_amount_required / $model->loan_term), 3);
                // create weekly payments, and on repayment, mark respective record with status REPAID.
                // loan term - no if weekly payments.
                for ($i = 1; $i <= $model->loan_term; $i++) {
                    $weeklyRepayment = new LoanRepayment();
                    $weeklyRepayment->user_id = $model->user_id;
                    $weeklyRepayment->loan_id = $model->id;
                    $weeklyRepayment->amount_paid = $weeklyRepaymentAmount;
                    $weeklyRepayment->state_id = Constants::WEEKLY_REPAYMENT_PENDING;
                    $weeklyRepayment->weekly_payment_date = Carbon::now()->addWeeks($i);
                    $weeklyRepayment->save();
                }
            }
            $model->state_id = $request->state_id;
            $model->save();
            DB::commit();
            return $this->success([
                'data' => new LoanResource($model),
                'message' => 'Loan Application updated successfully.'
            ]);
        } catch (\Illuminate\Database\QueryException $exception) {
            DB::rollback();
            return $this->error($exception->errorInfo);
        }
    }
}
