<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $guarded = [];
    const RESULT_DESTINATIONS = ['PERSON', 'ITTA', 'RUBIKA', 'BALE', 'EMAIL'];

    /**
     * @return bool
     */
    public function resDesIsEmail(): bool
    {
        return $this->getAttribute('result_destination') == 'EMAIL';
    }

    /**
     * @return HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateSpecialID(): string
    {
        return Str::random(6);
    }
}
