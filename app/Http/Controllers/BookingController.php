<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Requests\CancelSpotsRequest;
use App\Requests\RequestFactory;
use App\Rules\CancellableSpots;
use App\Rules\SeatsAvailable;
use App\Services\BookSpotsService;
use App\Services\CancelSpotsService;
use App\Services\CreateUserIfNotExists;
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
            'number_of_seats'=>['required','numeric','gt:0',new SeatsAvailable],
            'trip_id'=>['required',Rule::exists('trips','id')->where('status',Trip::OPEN)],
            'email'=>['required','email'],
            'name'=>['required']
        ]);
        $user = CreateUserIfNotExists::getUserOrCreateIfNotExists(RequestFactory::createRequest('user',$request));
        $request->user_id = $user->id;
        $bookSpot = new BookSpotsService(RequestFactory::createRequest('spot',$request));


        # code...
    }

    public function cancel(Request $request)
    {
        $this->validate($request,[
            'ticket_id'=>['required','exists:tickets,id'],
            'spots_to_cancel'=>['required','numeric',new CancellableSpots]
        ]);
        $cancelSpot = new CancelSpotsService(RequestFactory::createRequest('ticket',$request));
        # code...
    }

    //
}
