<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'company_name', 'email', 'phone_number', 'is_duplicate'
    ];

    protected $casts = [
        'is_duplicate' => 'boolean',
    ];
}
