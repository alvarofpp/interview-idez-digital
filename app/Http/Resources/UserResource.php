<?php

namespace App\Http\Resources;

use App\Traits\DetailedResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    use DetailedResource;

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
        ];
    }

    /**
     * Sets the additional details of the resource.
     *
     * @param array $data
     * @return array
     */
    private function details(array $data): array
    {
        $data['accounts'] = AccountResource::collection($this->accounts);

        return $data;
    }
}
