<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserInfoResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::query()->where('mobile', $data['mobile'])->firstOrFail();
        $checked = Hash::check($data['password'], $user->getAttribute('password'));
        if (!$checked) {
            throw new CustomException('wrong mobile or password');
        }

        $token = $user->newToken($user->getAttribute('mobile'));

        return successResponse([
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::query()->where('mobile', $data['mobile'])->first();
        if (exists($user)) {
            throw new CustomException('user already has an account');
        }
        $data['password'] = Hash::make($data['password']);
        User::query()->create($data);
        return successResponse();
    }

    /**
     * @return JsonResponse
     */
    public function info(): JsonResponse
    {
        $data = UserInfoResource::make(authUser());
        return successResponse([
            'data' => $data
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function orders(): JsonResponse
    {
        $user = authUser();

        return successResponse([
            'orders' => $user->orders
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editName(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required'
        ]);

        $user = authUser();
        $user->update($data);
        return successResponse();
    }
}
