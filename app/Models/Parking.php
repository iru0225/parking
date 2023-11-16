<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'car_number',
        'time_in',
        'time_out',
        'price',
        'status'
    ];

    protected $casts = [
        'id' => 'string'
    ];
}
