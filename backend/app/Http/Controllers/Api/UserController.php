<?php

namespace App\Http\Controllers\Api;

use App\Application\Actions\User\CreateUserAction;
use App\Application\Actions\User\DeleteUserAction;
use App\Application\Actions\User\UpdateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        return UserResource::collection(
            User::forCurrentTenant()
                ->latest()
                ->paginate()
        );
    }

    public function store(
        StoreUserRequest $request,
        CreateUserAction $action,
    ) {
        $this->authorize('create', User::class);

        $user = $action->execute(
            $request->name,
            $request->email,
            $request->password,
            $request->tenant_id,
            $request->role,
        );

        return new UserResource($user);
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        return new UserResource($user);
    }

    public function update(
        UpdateUserRequest $request,
        User $user,
        UpdateUserAction $action,
    ) {
        $this->authorize('update', $user);

        $user = $action->execute(
            $user,
            $request->validated(),
        );

        return new UserResource($user);
    }

    public function destroy(
        User $user,
        DeleteUserAction $action,
    ) {
        $this->authorize('delete', $user);

        $action->execute($user);

        return response()->json([
            'message' => 'User deleted',
        ]);
    }
}
