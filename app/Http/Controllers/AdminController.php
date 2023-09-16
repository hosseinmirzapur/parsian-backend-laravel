<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\ChangeUserStatusRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    /**
     * @param AdminLoginRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function login(AdminLoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $admin = Admin::query()->where('username', $data['username'])->firstOrFail();
        $check = password_verify($data['password'], $admin->password);
        if (!$check) {
            throw new CustomException('wrong username or password');
        }

        $token = $admin->newToken($data['username']);

        return successResponse([
            'admin' => $admin,
            'token' => $token
        ]);
    }

    /**
     * @param ChangeUserStatusRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function changeUserStatus(ChangeUserStatusRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();
        $user->update($data);
        return successResponse();
    }
}
