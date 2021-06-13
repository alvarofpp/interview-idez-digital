<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'cpf' => $this->cpf_masked,
            'telephone' => $this->telephone_masked,
            'email' => $this->email,
            'accounts' => AccountResource::collection($this->whenLoaded('accounts')),
        ];
    }
}
