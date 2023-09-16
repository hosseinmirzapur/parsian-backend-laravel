<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use HasApiTokens;

    protected $guarded = ['id'];

    /**
     * @param string $username
     * @return string
     */
    public function newToken(string $username): string
    {
        return $this->createToken($username)->plainTextToken;
    }
}
