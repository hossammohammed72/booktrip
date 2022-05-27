<?php

namespace Tests;

use App\Models\City;
use App\Models\Trip;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BookingTest extends TestCase
{

    public function createTrip()
    {
        $cities = City::inRandomOrder()->limit(2)->get()->toArray();
        $derpartureTime = time()+3600;
        $arrivalTime = $derpartureTime+12000;
        return $this->post('/trips',[
            'number_of_seats'=>15,
            'from'=>$cities[0]['name'],
            'to'=>$cities[1]['name'],
            'price'=>10.2,
            'derparture_time'=>date('d-m-y h:m',$derpartureTime),
            'arrival_time'=>date('d-m-y h:m',$arrivalTime)
             /* adding two minutes buffer*/ 
        ]);
        # code...
    }
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_base__booking_trip_returns_successful_response()
    {
        $tripId= $this->createTrip()->response->json()['trip']['id'];
       
        $this->post('/ticket/book',[
            'number_of_seats'=>1,
            'trip_id'=>$tripId,
            'name'=>'ahmed',
            'email'=>'baaaal@caaa'
        ]);
        $this->assertResponseStatus(201);
    }

      /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_base__booking_trip_returns_failure_on_seats_bigeer_than_trip_capacity_response()
    {
        $trip= $this->createTrip()->response->json()['trip'];
       
        $this->post('/ticket/book',[
            'number_of_seats'=>$trip['number_of_seats']+1,
            'trip_id'=>$trip['id'],
            'name'=>'ahmed',
            'email'=>'baaaal@caaa'
        ]);
        $this->assertResponseStatus(422);
    }

      /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_base__booking_trip_returns_failure_on_seats_bigeer_than_trip_available_seats_response()
    {
        $trip= $this->createTrip()->response->json()['trip'];
       
        $this->post('/ticket/book',[
            'number_of_seats'=>$trip['remaining_seats']+1,
            'trip_id'=>$trip['id'],
            'name'=>'ahmed',
            'email'=>'baaaal@caaa'
        ]);
        $this->assertResponseStatus(422);
    }
}
