<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spot extends Model 
{
  const FREE='free';
  const RESERVED='reserved';
  const STATUSES = [
    self::FREE,
    self::RESERVED
  ];

    
}
