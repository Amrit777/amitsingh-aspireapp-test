<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'loan_amount_required' => $this->loan_amount_required,
            'user_monthly_earnings' => $this->user_monthly_earnings,
            'loan_term' => $this->loan_term,
            'balance' => round($this->balance, 3),
            'repayment_amount' => round($this->repay_amount, 3),
            'user' => $this->user,
            'state_id' => $this->state_id,
            'deleted_at' => $this->deleted_at,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'weekly_repayments' => $this->loanRepayment,
        ];
    }

    public static function collection($data)
    {
        /* is_a() makes sure that you don't just match AbstractPaginator
     * instances but also match anything that extends that class.
     */
        if (is_a($data, \Illuminate\Pagination\AbstractPaginator::class)) {
            $data->setCollection(
                $data->getCollection()->map(function ($listing) {
                    return new static($listing);
                })
            );
            return $data;
        }
        return parent::collection($data);
    }

    public function toResponse($request)
    {
        return JsonResource::toResponse($request);
    }
}
