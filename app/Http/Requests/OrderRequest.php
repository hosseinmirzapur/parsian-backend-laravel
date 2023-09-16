<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
        return $this->isMethod('post') ? $this->postRules()  : $this->putRules();
    }

    protected function postRules(): array
    {
        return [
            'mobile' => ['required', 'regex:/^09(1[0-9]|3[1-9]|2[1-9])-?[0-9]{3}-?[0-9]{4}$/'],
            'customer_name' => 'required',
            'requester_name' => 'nullable',
            'result_destination' => ['required', Rule::in(Order::RESULT_DESTINATIONS)],
            'result_email' => ['nullable', 'email']
        ];
    }

    protected function putRules(): array
    {
        return [
            'customer_name' => 'nullable',
            'requester_name' => 'nullable',
            'result_destination' => ['nullable', Rule::in(Order::RESULT_DESTINATIONS)],
            'result_email' => ['nullable', 'email']
        ];
    }


}
