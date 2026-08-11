<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['order_number', 'total', 'items'];

    protected $casts = [
        'items' => 'array',
    ];
}