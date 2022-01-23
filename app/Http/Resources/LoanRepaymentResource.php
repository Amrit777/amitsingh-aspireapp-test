<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanRepaymentResource extends JsonResource
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
            'status' => $this->status(),
            'amount_paid' => $this->amount_paid,
            'weekly_payment_date' => $this->weekly_payment_date,
            'paid_date' => $this->paid_date,
            'state_id' => $this->state_id,
            'deleted_at' => $this->deleted_at,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'remaining_balance' => $this->remaining_balance,
            'payment_method' => $this->payment_method,
            'bank_transaction_details' => $this->bank_transaction_details,
            'user' => $this->user,
            'loan' => $this->loan,
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
}
