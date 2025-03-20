<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\v1\UserProfileRequest;
use App\Services\UserProfileService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserProfileService $userService)
    {
        $this->userService = $userService;
    }

    public function getUsers(Request $request)
    {
        $listar = $this->userService->listarUsers($request);
        return response()->json($listar['data'])->header('total_rows', $listar
    ['total']);
    }

    public function createUser(UserProfileRequest $request)
    {
        $user = $this->userService->createUser($request);
        return response()->json($user, 201);
    }

    public function editUser(UserProfileRequest $request, $id)
    {
        $user = $this->userService->editUser($request,$id);
        return response()->json($user);
    }

    public function updatePassword(Request $request)
    {
        $user = $this->userService->updatePassword($request);
        return response()->json($user);
    }

    public function recoverPassword(Request $request)
    {
        $user = $this->userService->recoverPassword($request);
        return response()->json($user);
    }

    public function changeState($id)
    {
        $user = $this->userService->changeState($id);
        return response()->json($user);
    }

    public function unblockedUser($id)
    {
        $userUnblocked = $this->userService->unblockedUser($id);
        return response()->json($userUnblocked);
    }
}
