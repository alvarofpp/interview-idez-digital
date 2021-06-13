<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\DestroyRequest;
use App\Http\Requests\Account\ShowRequest;
use App\Http\Requests\Account\StoreRequest;
use App\Http\Requests\Account\UpdateRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\Company;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $account = Account::create([
                'bank_branch' => $request->get('bank_branch'),
                'number' => $request->get('number'),
                'digit' => $request->get('digit'),
                'account_type_id' => $request->get('account_type_id'),
                'user_id' => Auth::id(),
            ]);

            if ($request->get('account_type_id') == AccountType::TYPE_COMPANY) {
                Company::create([
                    'cnpj' => unmaskValue($request->get('cnpj')),
                    'company_name' => $request->get('company_name'),
                    'trading_name' => $request->get('trading_name'),
                    'account_id' => $account->id,
                ]);
            }

            $account->load([
                'accountType',
                'company',
            ]);

            $accountResource = new AccountResource($account);

            DB::commit();
            return $this->responseSuccess([
                'message' => trans('controllers.AccountController.store.success'),
                'data' => $accountResource,
            ], Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseErrorServer([
                'message' => trans('controllers.AccountController.store.error'),
                'exception' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param ShowRequest $request
     * @param int $id
     * @return AccountResource
     */
    public function show(ShowRequest $request, int $id)
    {
        $account = Account::query()
            ->with([
                'accountType',
                'company',
                'transactions.accountFrom.user',
                'transactions.accountTo.user',
            ])
            ->findOrFail($id);

        return new AccountResource($account);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, int $id)
    {
        $data = $request->all();
        $account = Account::findOrFail($id);

        DB::beginTransaction();
        try {
            if ($account->is_company) {
                $account->load(['company']);
                $company = $account->company;

                // Updates company's data
                $keys = array_intersect($company->getFillable(), array_keys($data));
                $keysFlip = array_flip($keys);
                $dataCompany = array_intersect_key($data, $keysFlip);
                $company->update($dataCompany);

                // Removes company's data from data array
                $data = array_diff_key($data, $keysFlip);
            }

            tap($account)->update($data);
            $account->load(['accountType']);

            DB::commit();
            return $this->responseSuccess([
                'message' => trans('controllers.AccountController.update.success'),
                'data' => new AccountResource($account),
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseErrorServer([
                'message' => trans('controllers.AccountController.update.error'),
                'exception' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DestroyRequest $request, int $id)
    {
        Account::destroy($id);

        return $this->responseSuccess([
            'message' => trans('controllers.AccountController.destroy.success'),
        ]);
    }
}
