<?php

namespace App\Models;

use App\Http\Controllers\AuthController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class LoginToken extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'token',
        'user_id'
    ];

    public function Auth(){
        return $this->belongsTo(Auth::class,'user_id');
    }
}
