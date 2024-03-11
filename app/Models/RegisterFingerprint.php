<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterFingerprint extends Model
{
    use HasFactory;

    protected $fillable = ['folder', 'filename'];

    protected $casts = [
        'user_id' => 'integer',
        
    ];

}
