<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\OrderRequest;
use App\Models\Order;

use Illuminate\Http\JsonResponse;


class OrderController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = Order::query()->orderByDesc('id')->get();

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

        $order->load(['orderItems', 'user']);

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

        if (!$order->canBeChanged()) {
            throw new CustomException('order can not be updated');
        }
        $order->update($data);

        return successResponse();
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws CustomException
     */
    public function destroy($id): JsonResponse
    {
        $order = Order::query()->findOrFail($id);

        if (!$order->canBeChanged()) {
            throw new CustomException('order can not be deleted');
        }
        $order->delete();

        return successResponse();
    }

    /**
     * @param array $data
     * @return void
     */
    private function handleUser(array &$data): void
    {
        $data['user_id'] = authUser()->getAttribute('id');
    }
}
