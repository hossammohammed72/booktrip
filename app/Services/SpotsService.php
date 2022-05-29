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
                'number_of_spots'=>$request->numberOfSpots,
                'user_id'=>$request->userId,
                'trip_id'=>$trip->id,
                'tikcet_total'=>$trip->price*$request->numberOfSpots
            ]);
            $ticket->save();
            Spot::where('trip_id',$trip->id)
            ->whereNull('ticket_id')
            ->where('status',Spot::FREE)
            ->orderBy('spot_number')->offset($trip->number_of_spots-$trip->remaining_spots)->limit($request->numberOfSpots)
            ->lockForUpdate()
            ->update(
                ['ticket_id'=>$ticket->id,'status'=>Spot::RESERVED]
            );
            $trip->remaining_spots = $trip->remaining_spots-$request->numberOfSpots;
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
            ->orderBy('spot_number','DESC')->limit($request->numberOfSpots)
            ->lockForUpdate()
            ->update(
                ['ticket_id'=>null,'status'=>Spot::FREE]
            );
            $trip= Trip::find($ticket->trip_id)->lockForUpdate()->first();
            $trip->remaining_spots = $trip->remaining_spots+$request->numberOfSpots;
            $trip->update();
            $ticket->number_of_spots = $ticket->number_of_spots-$request->numberOfSpots;
            $ticket->save();
            return $ticket;
         });
    }
}

?>