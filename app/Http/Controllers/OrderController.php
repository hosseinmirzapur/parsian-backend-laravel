<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $order = Order::query()->create($data + ['special_id' => Order::generateSpecialID()]);
        return successResponse([
            'order' => $order
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
}
