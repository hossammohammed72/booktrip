<?php 
namespace App\Services;

use App\Events\Event;
use App\Events\TripCreatedEvent;
use App\Models\Spot;
use App\Models\Ticket;
use App\Models\Trip;
use App\Requests\BookingSpotsRequest;
use App\Requests\TripRequest;

class BookSpotsService{
    public function __construct(BookingSpotsRequest $request)
    {
         app('db')->transaction(function()use($request){
            $trip = $request->trip;
            $trip->lockForUpdate();
            $ticket = new Ticket([
                'number_of_spots'=>$request->numberOfSeats,
                'user_id'=>$request->userId,
                'trip_id'=>$trip->id,
                'tikcet_total'=>$trip->price*$request->numberOfSeats
            ]);
            $ticket->save();
            Spot::where('trip_id',$trip->id)
            ->whereNull('ticket_id')
            ->where('status',Spot::FREE)
            ->orderBy('spot_number')->offset($trip->number_of_seats-$trip->remaining_seats)->limit($request->numberOfSeats)
            ->lockForUpdate()
            ->update(
                ['ticket_id'=>$ticket->id,'status'=>Spot::RESERVED]
            );
            $trip->remaining_seats = $trip->remaining_seats-$request->numberOfSeats;
            $trip->update();
         });
    }
}

?>