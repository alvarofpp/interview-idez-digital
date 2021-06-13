<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\DestroyRequest;
use App\Http\Requests\User\IndexRequest;
use App\Http\Requests\User\ShowRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\User;

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

        if ($request->filled('q')) {
            $query = $query->searchBy($request->get('q'));
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
    public function show(ShowRequest $request, int $id)
    {
        $user = User::query()
            ->with([
                'accounts',
            ])
            ->findOrFail($id);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, int $id)
    {
        $user = User::findOrFail($id);
        $data = $request->only([
            'name',
            'email',
            'cpf',
            'telephone',
            'password',
        ]);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->get('password'));
        }

        tap($user)->update($data);

        $userResource = new UserResource($user);

        return $this->responseSuccess([
            'message' => trans('controllers.UserController.update.success'),
            'data' => $userResource,
        ]);
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
        User::destroy($id);

        return $this->responseSuccess([
            'message' => trans('controllers.UserController.destroy.success'),
        ]);
    }
}
