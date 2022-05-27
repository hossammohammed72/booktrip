<?php 
namespace App\Services;

use App\Events\Event;
use App\Events\TripCreatedEvent;
use App\Models\Spot;
use App\Models\Ticket;
use App\Models\Trip;
use App\Requests\BookingSpotsRequest;
use App\Requests\CancelSpotsRequest;
use App\Requests\TripRequest;

class CancelSpotsService{
    public static function cancel(CancelSpotsRequest $request)
    {
         return app('db')->transaction(function()use($request){
            $ticket = $request->ticket;
            $ticket->lockForUpdate();
            Spot::where('ticket_id',$ticket->id)
            ->where('status',Spot::RESERVED)
            ->orderBy('spot_number','DESC')->limit($request->numberOfSeats)
            ->lockForUpdate()
            ->update(
                ['ticket_id'=>null,'status'=>Spot::FREE]
            );
            $trip= Trip::find($ticket->trip_id)->lockForUpdate()->first();
            $trip->remaining_seats = $trip->remaining_seats+$request->numberOfSeats;
            $trip->update();
            $ticket->number_of_spots = $ticket->number_of_spots-$request->numberOfSeats;
            $ticket->save();
            return $ticket;
         });
    }
}

?>