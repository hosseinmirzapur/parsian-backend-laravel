<?php

namespace App\Http\Requests;

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

    public function postRules(): array
    {
        return [
            'name' => 'required',
            'sand_paper' => ['required', 'boolean'],
            'destruction' => ['required', 'boolean'],
            'status' => ['required', Rule::in(OrderItem::STATUS)],
            'test_type' => ['required', Rule::in(OrderItem::TEST_TYPES)],
            'quantity' => ['required', 'min:1'],
            'description' => 'nullable',
            'image' => ['nullable', 'image'],
            'order_id' => ['required', Rule::exists('orders', 'id')],
        ];
    }

    public function putRules(): array
    {
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
