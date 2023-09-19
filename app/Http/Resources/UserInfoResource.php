<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'mobile' => $this->mobile,
            'name' => $this->name,
            'status' => $this->status,
            'orders_count' => $this->orders()->with('orderItems')->get()->count(),
            'registered_at' => $this->created_at,
        ];
    }
}
