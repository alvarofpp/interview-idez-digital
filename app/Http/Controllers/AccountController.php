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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $data = $request->all();

        DB::beginTransaction();
        try {
            $account = Account::create([
                'bank_branch' => $data['bank_branch'],
                'number' => $data['number'],
                'digit' => $data['digit'],
                'account_type_id' => $data['account_type_id'],
                'user_id' => Auth::id(),
            ]);

            if ($data['account_type_id'] == AccountType::TYPE_COMPANY) {
                Company::create([
                    'cnpj' => $data['cnpj'],
                    'company_name' => $data['company_name'],
                    'trading_name' => $data['trading_name'],
                    'account_id' => $account->id,
                ]);
            }

            $accountResource = new AccountResource($account);

            DB::commit();
            return $this->responseSuccess([
                'message' => trans('controllers.AccountController.store.success'),
                'data' => $accountResource,
            ], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseErrorServer([
                'message' => trans('controllers.AccountController.store.success'),
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
    public function show(ShowRequest $request, $id)
    {
        $account = Account::findOrFail($id);
        $accountResource = new AccountResource($account, true);

        return $accountResource;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, $id)
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
            $accountResource = new AccountResource($account);

            DB::commit();
            return $this->responseSuccess([
                'message' => trans('controllers.AccountController.update.success'),
                'data' => $accountResource,
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
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DestroyRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            Account::destroy($id);

            DB::commit();
            return $this->responseSuccess([
                'message' => trans('controllers.AccountController.destroy.success'),
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseErrorServer([
                'message' => trans('controllers.AccountController.destroy.error'),
                'exception' => $exception->getMessage(),
            ]);
        }
    }
}
