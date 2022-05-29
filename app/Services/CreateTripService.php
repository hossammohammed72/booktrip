<?php 
namespace App\Services;

use App\Events\Event;
use App\Events\TripCreatedEvent;
use App\Models\Trip;
use App\Requests\TripRequest;

class CreateTripService{
    public static function create(TripRequest $request)
    {
        $trip = new Trip();
        $trip->number_of_spots=$request->numberOfSpots;
        $trip->remaining_spots=$request->numberOfSpots;
        $trip->from_city_id=$request->from->id;
        $trip->to_city_id=$request->to->id;
        $trip->ticket_price=$request->price;
        $trip->derpature_time = $request->derpartureTime;
        $trip->arrival_time = $request->arrivalTime;
        $trip->save();
        event(new TripCreatedEvent($trip));  
        return $trip; 
    }
}

?>