<?php 
namespace App\Requests;

use App\Models\City;
class TripRequest{
    
    public function __construct(
    public int $numberOfSeats,
    public City $from,
    public City $to,
    public float $price,
    public string $derpartureTime,
    public string $arrivalTime,
    )
    {}
}
?>