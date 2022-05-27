<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Trip;
use App\Requests\RequestFactory;
use App\Services\CreateTripService;
use App\Services\CreateUserIfNotExists;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TripController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * store
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request):JsonResponse{
        try{
            $this->validate($request,[
                'number_of_seats'=>'required|numeric|gt:0',
                'from'=>'required|exists:cities,name',
                'to'=>'required|exists:cities,name|not_in:'.($request->from??''),
                'price'=>'required|numeric|gt:0',
                'derparture_time'=>'required|after:'.date('d-m-y h:m'),
                'arrival_time'=>'required|after:derparture_time'
            ]);
            
            $trip = new CreateTripService(RequestFactory::createRequest('trip',$request));
            
            return response()->json(['message'=>'trip created Sucessfullly','trip'=>$trip,201]);
         
        }catch(ValidationException $e){
            Log::alert("validation exception");
            return response()->json(['message'=>'validation exception','erros'=>$e->getMessage()],400);
         
        }
        
    }

    public function showTickets($tripId)
    {
        return response()->json(Trip::with('tickets','tickets.user')->where('id',$tripId)->get()->toArray(),200);
        
        # code...
    }

    public function showUsers($tripId)
    {
        return response()->json(app('db')->table("tickets")->join('users','user_id','users.id')->where('trip_id',$tripId)->groupBy('user_id')->selectRaw('sum(number_of_spots) as total_spots,users.email,users.name')->get(),200);
        # code...
    }

    //
}
