<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountType\IndexRequest;
use App\Http\Resources\AccountTypeResource;
use App\Models\AccountType;

class AccountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(IndexRequest $request)
    {
        return AccountTypeResource::collection(AccountType::all());
    }
}
