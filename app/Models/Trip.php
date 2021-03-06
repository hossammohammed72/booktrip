<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model 
{
    use HasFactory;

    const PENDING='pending';
    const OPEN='open';
    const BOOKED='booked';
    const STATUSES=[
        self::PENDING,
        self::OPEN,
        self::BOOKED
    ];
    protected $fillable=['remaining_spots','price'];

    public function spots(){
        return $this->hasMany(Spot::class);
    }

    public function from()
    {
        return $this->belongsTo(City::class,'from_city_id');
    }

    public function to()
    {
        return $this->belongsTo(City::class,'to_city_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
