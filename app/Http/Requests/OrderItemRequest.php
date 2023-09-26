<?php

namespace App\Http\Requests;

use App\Models\Admin;
use App\Models\OrderItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return $this->isMethod('post') ? $this->postRules() : $this->putRules();
    }

    protected function postRules(): array
    {
        return [
            'name' => 'required',
            'sand_paper' => ['required', 'boolean'],
            'destruction' => ['required', 'boolean'],
            'test_type' => ['required', Rule::in(OrderItem::TEST_TYPES)],
            'quantity' => ['required', 'min:1'],
            'description' => 'nullable',
            'image' => ['nullable', 'image'],
            'order_id' => ['required', Rule::exists('orders', 'id')],
        ];
    }

    protected function putRules(): array
    {
        return authUser() instanceof Admin ? $this->updateByAdminRules() : $this->updateByUserRules();
    }

    protected function updateByUserRules(): array {
        return [
            'name' => 'nullable',
            'sand_paper' => ['nullable', 'boolean'],
            'destruction' => ['nullable', 'boolean'],
            'test_type' => ['nullable', Rule::in(OrderItem::TEST_TYPES)],
            'quantity' => ['nullable', 'min:1'],
            'description' => 'nullable',
        ];
    }

    protected function updateByAdminRules(): array {
        return [
            'name' => 'nullable',
            'sand_paper' => ['nullable', 'boolean'],
            'destruction' => ['nullable', 'boolean'],
            'status' => ['nullable', Rule::in(OrderItem::STATUS)],
            'test_type' => ['nullable', Rule::in(OrderItem::TEST_TYPES)],
            'quantity' => ['nullable', 'min:1'],
            'description' => 'nullable',
        ];
    }
}
