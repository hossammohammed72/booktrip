<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model 
{
    use HasFactory;
    protected $fillable = ['number_of_spots','total_price','user_id','trip_id'];
    /**
     * trip
     *
     * @return void
     */
    public function trip(){
        return $this->belongsTo(Trip::class);
    }
    /**
     * user
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
        # code...
    }

    
}
