<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $guarded = ['id'];
    const STATUS = ['PENDING', 'PARTIAL', 'OFFICE', 'PAID'];
    const TEST_TYPES = ['ANALYZE', 'HARDNESS', 'BOTH'];

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @param $value
     * @return string
     */
    public function getImageAttribute($value): string
    {
        return config('filesystems.disks.liara.url') . '/' . $value;
    }

    public function getCreatedAtAttribute($value): string
    {
        return verta($value)->format('Y/m/d H:i');
    }
}
