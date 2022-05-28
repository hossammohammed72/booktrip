<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Requests\RequestFactory;
use App\Rules\CancellableSpots;
use App\Rules\SeatsAvailable;
use App\Services\BookSpotsService;
use App\Services\SpotsService;
use App\Services\UserService;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class BookingController extends Controller
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

    public function book(Request $request)
    {
        $this->validate($request,[

            'trip_id'=>['required',Rule::exists('trips','id')->where('status',Trip::OPEN)],
            'number_of_seats'=>['required','numeric','gt:0',new SeatsAvailable],
            'email'=>['required','email'],
            'name'=>['required']
        ]);
        $user = UserService::getOrCreate(RequestFactory::createRequest('user',$request));
        $request->user_id = $user->id;
        $ticket = SpotsService::book(RequestFactory::createRequest('spot',$request));

        return response()->json(['message'=>'ticket created Sucessfullly','ticket'=>$ticket],201);

        # code...
    }

    public function cancel(Request $request)
    {
        $this->validate($request,[
            'ticket_id'=>['required','exists:tickets,id'],
            'spots_to_cancel'=>['required','numeric',new CancellableSpots]
        ]);
        $ticket = SpotsService::cancel(RequestFactory::createRequest('ticket',$request));
        return response()->json(['message'=>'spots cancelled Sucessfullly','ticket'=>$ticket,'number_of_cancelled_spots'=>$request->spots_to_cancel],201);

        # code...
    }

    //
}
