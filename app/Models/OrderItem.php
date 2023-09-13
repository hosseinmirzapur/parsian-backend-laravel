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

}
