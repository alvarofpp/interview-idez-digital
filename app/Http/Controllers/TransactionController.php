<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\StoreRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @param int $accountId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request, int $accountId)
    {
        $transaction = Transaction::create([
            'value' => $request->get('value'),
            'transaction_type_id' => $request->get('transaction_type_id'),
            'account_to_id' => $request->get('account_to_id'),
            'account_from_id' => $accountId,
        ]);
        $transaction->load([
            'accountFrom.user',
            'accountFrom.company',
            'accountFrom.accountType',
            'accountTo.user',
            'accountTo.company',
            'accountTo.accountType',
            'transactionType',
        ]);

        return $this->responseSuccess([
            'message' => trans('controllers.TransactionController.store.success'),
            'data' => new TransactionResource($transaction),
        ], Response::HTTP_CREATED);
    }
}
