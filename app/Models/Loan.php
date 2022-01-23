<?php

namespace App\Models;

use App\Constant\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'loan_amount_required',
        'user_monthly_earnings',
        'loan_term',
        'user_id',
        'state_id',
        'deleted_at',
        'amount_sactioned_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function loanRepayment()
    {
        return $this->hasMany(LoanRepayment::class, 'loan_id', 'id');
    }

    public function getBalanceAttribute()
    {
        return round(abs($this->loan_amount_required - $this->loanRepayment->where('state_id', Constants::WEEKLY_REPAID)->sum('amount_paid')), 3);
    }

    public function getRepayAmountAttribute()
    {
        return ($this->loan_amount_required / $this->loan_term);
    }
}
