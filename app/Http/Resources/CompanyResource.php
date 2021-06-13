<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'cnpj' => $this->cnpj_masked,
            'company_name' => $this->company_name,
            'trading_name' => $this->trading_name,
            'account' => new AccountResource($this->whenLoaded('account')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
