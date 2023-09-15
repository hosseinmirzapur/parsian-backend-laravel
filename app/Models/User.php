<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
