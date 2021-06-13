<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'created_at' => $this->created_at->format('d/m/Y - H:i:s'),
            'transaction_type' => new TransactionTypeResource($this->whenLoaded('transactionType')),
            'account_from' => new AccountResource($this->whenLoaded('accountFrom')),
            'account_to' => new AccountResource($this->whenLoaded('accountTo')),
        ];
    }
}
