<?php 
namespace App\Requests;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Ticket;
use App\Models\Trip;

class RequestFactory{
    public static function createRequest(string $requestName, Request $request)
    {
        switch ($requestName){
            case 'trip':
                return new TripRequest(
                    numberOfSpots:$request->number_of_spots,
                    from:City::where('name',$request->from)->first(),
                    to:City::where('name',$request->to)->first(),
                    price:$request->price,
                    derpartureTime:$request->derparture_time,
                    arrivalTime:$request->arrival_time);
                break;
            case 'spot':
                return new BookingSpotsRequest(
                    numberOfSpots:$request->number_of_spots,
                    trip:Trip::find($request->trip_id),
                    userId:$request->user_id  
                );
            case 'user':
                return new UserRequest(
                    email:$request->email,
                    name:$request->name,
                );
                break;
            case 'ticket':
                return new CancelSpotsRequest(
                    numberOfSpots:$request->spots_to_cancel,
                    ticket:Ticket::find($request->ticket_id)
                );
        }
    }
}
?>