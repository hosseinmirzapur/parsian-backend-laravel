<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $guarded = ['id'];
    const RESULT_DESTINATIONS = ['PERSON', 'ITTA', 'RUBIKA', 'BALE', 'EMAIL'];

    protected $appends = ['status'];

    /**
     * @return bool
     */
    public function resDesIsEmail(): bool
    {
        return $this->getAttribute('result_destination') == 'EMAIL';
    }

    /**
     * @return bool
     */
    public function canBeUpdated(): bool
    {
        return !$this->status;
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
        return Str::lower(Str::random(6));
    }

    /**
     * @return bool
     */
    public function getStatusAttribute(): bool
    {
        $orderItems = $this->orderItems;
        $ready = true;
        foreach ($orderItems as $item) {
            if ($item->status != 'PAID') {
                $ready = false;
            }
        }

        if ($orderItems->count() == 0) {
            $ready = false;
        }
        return $ready;
    }
}
