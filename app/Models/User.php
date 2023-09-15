<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens;
    protected $guarded = ['id'];

    /**
     * @param string $mobile
     * @return string
     */
    public function newToken(string $mobile): string
    {
        return $this->createToken($mobile)->plainTextToken;
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
