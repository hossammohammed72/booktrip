<?php 
namespace App\Requests;

use App\Models\Trip;
use App\Models\User;

class BookingSpotsRequest{
    
    public function __construct(
    public int $numberOfSeats,
    public Trip $trip,
    public int $userId,
    )
    {}
}
?>