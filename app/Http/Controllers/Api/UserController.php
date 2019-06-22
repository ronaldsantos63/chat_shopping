<?php

namespace ChatShopping\Http\Controllers\Api;

use ChatShopping\Http\Requests\UserRequest;
use ChatShopping\Http\Resources\UserResource;
use ChatShopping\Models\User;
use ChatShopping\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->all());
        $user->password = bcrypt($user->password);
        $user->save();
        return new UserResource($user);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->fill($request->all());
        $user->password = bcrypt($user->password);
        $user->save();
        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([], 204);
    }
}
