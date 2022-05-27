<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model 
{

    const PENDING='pending';
    const OPEN='open';
    const BOOKED='booked';
    const STATUSES=[
        self::PENDING,
        self::OPEN,
        self::BOOKED
    ];
    protected $fillable=['remaining_seats','price'];
}
