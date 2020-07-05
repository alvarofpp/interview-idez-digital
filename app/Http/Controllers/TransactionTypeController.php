<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionType\IndexRequest;
use App\Http\Resources\TransactionTypeResource;
use App\Models\TransactionType;

class TransactionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(IndexRequest $request)
    {
        $transactionTypes = TransactionType::all();

        return TransactionTypeResource::collection($transactionTypes);
    }
}
