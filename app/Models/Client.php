<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'company_name', 'email', 'phone_number', 'is_duplicate'
    ];

    protected $casts = [
        'is_duplicate' => 'boolean',
    ];
}
