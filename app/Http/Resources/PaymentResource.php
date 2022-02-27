<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'ID' => $this->id,
            'Transaction ID' => $this->transaction_id,
            'Amount' => $this->amount,
            'Payment Method' => $this->payment_method,
            'Paid at' => $this->payment_date,
            'Details' => $this->details,

//            'Transaction' => ($this->transaction)? new TransactionResource($this->transaction): null,
//            'created_at' => $this->created_at,
        ];
    }
}
