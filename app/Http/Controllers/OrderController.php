<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OrderController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = Order::all();

        return successResponse([
            'orders' => $orders
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $order = Order::query()->findOrFail($id);

        $order->load('orderItems');

        return successResponse([
            'order' => $order
        ]);
    }

    /**
     * @param OrderRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function store(OrderRequest $request): JsonResponse
    {
        $data = filterData($request->validated());
        $this->handleUser($data);
        $data['special_id'] = Order::generateSpecialID();
        Order::query()->create($data);
        return successResponse([
            'orders' => Order::query()->orderByDesc('id')->get()
        ]);
    }

    /**
     * @param OrderRequest $request
     * @param $id
     * @return JsonResponse
     * @throws CustomException
     */
    public function update(OrderRequest $request, $id): JsonResponse
    {
        $order = Order::query()->findOrFail($id);

        $data = filterData($request->validated());

        $order->update($data);

        return successResponse();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $order = Order::query()->findOrFail($id);

        $order->delete();

        return successResponse();
    }

    /**
     * @param array $data
     * @return void
     * @throws CustomException
     */
    private function handleUser(array &$data): void
    {
        $mobile = $data['mobile'];
        $user = User::query()->where('mobile', $mobile)->first();
        if (!$user) {
            throw new CustomException('mobile does not belong to any existing user');
        }

        $data['user_id'] = $user->id;
    }
}
