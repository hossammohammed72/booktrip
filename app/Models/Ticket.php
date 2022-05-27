<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model 
{
    protected $fillable = ['number_of_spots','total_price','user_id','trip_id'];

    
}
