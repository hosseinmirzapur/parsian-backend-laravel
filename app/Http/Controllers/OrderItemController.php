<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\OrderItemRequest;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;

class OrderItemController extends Controller
{
    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $order_item = OrderItem::query()->findOrFail($id);
        $order_item->load('order');
        return successResponse([
            'order_item' => $order_item
        ]);
    }

    /**
     * @param OrderItemRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function store(OrderItemRequest $request): JsonResponse
    {
        $data = filterData($request->validated());
        $this->handleImage($data);
        $order_item = OrderItem::query()->create($data);
        return successResponse([
            'order_item' => $order_item
        ]);
    }

    /**
     * @param OrderItemRequest $request
     * @param $id
     * @return JsonResponse
     * @throws CustomException
     */
    public function update(OrderItemRequest $request, $id): JsonResponse
    {
        $data = filterData($request->validated());
        $order_item = OrderItem::query()->findOrFail($id);
        $order_item->update($data);
        return successResponse();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $order_item = OrderItem::query()->findOrFail($id);
        $order_item->delete();
        return successResponse();
    }

    /**
     * @param $data
     * @return void
     * @throws CustomException
     */
    private function handleImage(&$data): void
    {
        if (exists($data['image'])) {
            $data['image'] = handleFile($data['image']);
        }
    }
}
