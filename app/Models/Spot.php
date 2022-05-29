<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spot extends Model 
{
  use HasFactory;
  const FREE='free';
  const RESERVED='reserved';
  const STATUSES = [
    self::FREE,
    self::RESERVED
  ];
  /**
   * Undocumented function
   *
   * @return void
   */
  public function ticket(){
    return $this->belongsTo(Ticket::class);
  }
  /**
   * Undocumented function
   *
   * @return void
   */
  public function trip(){
    return $this->belongsTo(Trip::class);
  }
    
}
