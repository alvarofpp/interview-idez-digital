<?php

namespace App\Http\Resources;

use App\Traits\DetailedResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    use DetailedResource;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'bank_branch' => $this->bank_branch,
            'number' => $this->number,
            'digit' => $this->digit,
            'account_type' => new AccountTypeResource($this->account_type),
        ];

        if ($this->is_company) {
            $data['company'] = new CompanyResource($this->company);
        }

        return $data;
    }

    /**
     * Sets the additional details of the resource.
     *
     * @param array $data
     * @return array
     */
    private function details(array $data): array
    {
        $data['user'] = new UserResource($this->user);

        $this->load([
            'transactions_made.account_from.user',
            'transactions_made.account_to.user',
            'transactions_received.account_from.user',
            'transactions_received.account_to.user',
        ]);
        $transactions = $this->transactions;
        $data['transactions'] = TransactionResource::collection($transactions);

        return $data;
    }
}
