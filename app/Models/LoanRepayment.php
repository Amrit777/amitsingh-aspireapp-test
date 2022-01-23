<?php

namespace App\Models;

use App\Constant\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanRepayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'loan_id',
        'amount_paid',
        'paid_date',
        'weekly_payment_date',
        'state_id',
        'remaining_balance',
        'payment_method',
        'bank_transaction_details',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function loan()
    {
        return $this->hasOne(Loan::class, 'id', 'loan_id');
    }

    public function status()
    {
        $status = [
            Constants::WEEKLY_REPAID => 'Payment Done',
            Constants::WEEKLY_REPAYMENT_PENDING => 'Payment Pending',
        ];
        return $status[$this->state_id];
    }
}
