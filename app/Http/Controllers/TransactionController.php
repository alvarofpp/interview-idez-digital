<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\StoreRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @param int $accountId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request, $accountId)
    {
        $data = $request->all();

        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'value' => $data['value'],
                'transaction_type_id' => $data['transaction_type_id'],
                'account_to_id' => $data['account_to_id'],
                'account_from_id' => $accountId,
            ]);
            $transaction->load([
                'account_from.user', 'account_from.company',
                'account_to.user', 'account_to.company',
                'transaction_type',]);
            $transactionResource = new TransactionResource($transaction);

            DB::commit();
            return $this->responseSuccess([
                'message' => trans('controllers.TransactionController.store.success'),
                'data' => $transactionResource,
            ], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseErrorServer([
                'message' => trans('controllers.TransactionController.store.error'),
                'exception' => $exception->getMessage(),
            ]);
        }
    }
}
