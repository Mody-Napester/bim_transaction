<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // Set Status Paid, Outstanding, Overdue
        if($this->payments && $this->payments()->sum('amount') == $this->amount){
            $status = 'Paid';
        }
        elseif($this->payments && $this->payments()->sum('amount') < $this->amount && $this->due_date >= date('Y-m-d')){
            $status = 'Outstanding';
        }
        elseif($this->payments && $this->payments()->sum('amount') < $this->amount && $this->due_date < date('Y-m-d')){
            $status = 'Overdue';
        }


        return [
            'ID' => $this->id,
            'Payer' => ($this->customer)? new UserResource($this->customer): null,
            'Category' => ($this->category)? new CategoryResource($this->category): null,
            'Subcategory' => ($this->sub_category)? new SubCategoryResource($this->sub_category): null,
            'Status' => $status,
            'Amount' => $this->amount,
            'Due on' => $this->due_date,

//            'vat' => $this->vat,
//            'is_vat_inclusive' => $this->is_vat_inclusive,
//            'created_at' => $this->created_at,
        ];
    }
}
