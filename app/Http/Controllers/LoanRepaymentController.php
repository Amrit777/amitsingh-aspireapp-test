<?php

namespace App\Http\Controllers;

use App\Constant\Constants;
use App\Http\Resources\LoanRepaymentResource;
use App\Models\Loan;
use App\Models\LoanRepayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanRepaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $limit = $request->limit;
        $limit = ($limit) ? $limit : Constants::PAGINATION_COUNT;
        $list = LoanRepayment::latest('id');
        if ($user->isUser()) {
            $list->where('user_id', $user->id);
        }
        if ($user->isAdmin()) {
            if ($request->filled('state_id')) {
                $list->where('state_id', $request->state_id);
            }
            if ($request->filled('user_id')) {
                $list->where('user_id', $request->user_id);
            }
        }

        $result = $list->paginate($limit);
        return $this->success(
            [
                'data' => LoanRepaymentResource::collection($result),
                'message' => 'Loan Repayments List fetched successfully'
            ]
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'loan_repayment_id' => 'required|numeric',
            'loan_id' => 'required|numeric',
            'amount_paid' =>  'required|numeric|gt:0',
            'payment_method' => 'required|numeric',
            'bank_transaction_details' => 'required_if:payment_method,' . Constants::REPAYMENT_METHOD_ONLINE
        ]);
        $model = Loan::findOrFail($request->loan_id);

        if ($model->state_id == Constants::LOAN_PROCESSING) {
            return $this->success("Your application is still process. Please wait for admin to approve it.");
        }
        if ($model->state_id == Constants::LOAN_ADMIN_REJECT) {
            return $this->success("Your application is rejected process.");
        }
        if ($model->state_id == Constants::LOAN_REPAID) {
            return $this->success("Your loan amount is repaid completely.");
        }
        $weeklyRepayment = LoanRepayment::findOrFail($request->loan_repayment_id);

        if ($weeklyRepayment->state_id == Constants::WEEKLY_REPAID) {
            return $this->failed("This weekly repayment is already done.");
        }
        if ($weeklyRepayment->amount_paid != $request->amount_paid) {
            return $this->failed("Please enter exact amount that needs to be paid for this weekly repayment.");
        }
        try {
            DB::beginTransaction();
            $remaining_balance = round((abs($model->balance - $weeklyRepayment->amount_paid)), 3);
            if ($request->filled('bank_transaction_details')) {
                $weeklyRepayment->bank_transaction_details = $request->bank_transaction_details;
            }
            $weeklyRepayment->payment_method = $request->payment_method;
            $weeklyRepayment->paid_date = Carbon::now()->toDateTimeString();
            $weeklyRepayment->remaining_balance = $remaining_balance;
            $weeklyRepayment->state_id = Constants::WEEKLY_REPAID;
            $weeklyRepayment->save();
            if ($remaining_balance <= 0) {
                $model->update(['state_id' => Constants::LOAN_REPAID]);
            }
            DB::commit();
            return $this->success([
                'data' => new LoanRepaymentResource($weeklyRepayment),
                'message' => 'Loan Repayment stored successfully.'
            ]);
        } catch (\Illuminate\Database\QueryException $exception) {
            DB::rollback();
            return $this->error($exception->errorInfo);
        }
    }
}
