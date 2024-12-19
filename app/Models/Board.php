<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Board extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'creator_id'
    ];

    public function Auth(){
        return $this->belongsTo(Auth::class, 'creator_id');
    }
}
