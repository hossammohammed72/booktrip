<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spot extends Model 
{
    const STATUSES = [
      'free',
      'reserved',  
    ];

    
}
