<?php

namespace App\Listeners;

use App\Events\TripCreatedEvent;
use App\Models\Spot;
use App\Models\Trip;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CreateSpotsListener implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Undocumented function
     *
     * @param TripCreatedEvent $event
     */
    public static function handle(TripCreatedEvent $event)
    {
         $numberOfSpotsInTrip = $event->trip->number_of_spots;
         $spotsArray=[];
         if($event->trip->status !== Trip::PENDING){
             return true;
         }
         for($i=1;$i<=$numberOfSpotsInTrip;$i++){
             $spotsArray[] = [
                 'spot_number'=>$i,
                 'trip_id'=>$event->trip->id,
                 'status'=>Spot::FREE,
             ];
         } 
         Spot::insert($spotsArray);
         $event->trip->status = Trip::OPEN;
         $event->trip->save();
    }


}
