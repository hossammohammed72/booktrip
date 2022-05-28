<?php 
namespace App\Services;

use App\Models\Spot;
use App\Models\Ticket;
use App\Models\Trip;
use App\Requests\BookingSpotsRequest;
use App\Requests\CancelSpotsRequest;

class SpotsService{
    public static function book(BookingSpotsRequest $request)
    {
         return app('db')->transaction(function()use($request){
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
            return $trip;
         });
    }

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