<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'bank_branch' => $this->bank_branch,
            'number' => $this->number,
            'digit' => $this->digit,
            'account_type' => new AccountTypeResource($this->whenLoaded('accountType')),
            'company' => new CompanyResource($this->whenLoaded('company')),
            'user' => new UserResource($this->whenLoaded('user')),
            'transactions' => TransactionResource::collection($this->whenLoaded('transactions')),
        ];
    }
}
