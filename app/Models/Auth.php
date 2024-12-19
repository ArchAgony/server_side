<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Auth extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'password'
    ];

    public function LoginToken(){
        return $this->hasMany(LoginToken::class);
    }

    public function Board(){
        return $this->hasMany(Board::class);
    }
}
