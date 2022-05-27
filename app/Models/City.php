<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model 
{

    public function tripsAsFrom()
    {
        return $this->hasMany(Trip::class,'from_city_id');
    }
    public function tripsAsTo()
    {
        return $this->hasMany(Trip::class,'to_city_id');
    }
}
