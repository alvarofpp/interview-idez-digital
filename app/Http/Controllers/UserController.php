<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\DestroyRequest;
use App\Http\Requests\User\IndexRequest;
use App\Http\Requests\User\ShowRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(IndexRequest $request)
    {
        $query = User::query();

        if ($search = $request->get('q')) {
            $query = $query->searchBy($search);
        }

        $users = $query->paginate();

        return UserResource::collection($users);
    }

    /**
     * Display the specified resource.
     *
     * @param ShowRequest $request
     * @param int $id
     * @return UserResource
     */
    public function show(ShowRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $userResource = new UserResource($user, true);

        return $userResource;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->all();
        $user = User::findOrFail($id);

        DB::beginTransaction();
        try {
            tap($user)->update($data);
            $userResource = new UserResource($user, true);

            DB::commit();
            return $this->responseSuccess([
                'message' => trans('controllers.UserController.update.success'),
                'data' => $userResource,
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseErrorServer([
                'message' => trans('controllers.UserController.update.error'),
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
    public function destroy(DestroyRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            User::destroy($id);

            DB::commit();
            return $this->responseSuccess([
                'message' => trans('controllers.UserController.destroy.success'),
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseErrorServer([
                'message' => trans('controllers.UserController.destroy.error'),
                'exception' => $exception->getMessage(),
            ]);
        }
    }
}
