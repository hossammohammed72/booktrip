<?php

namespace Tests;

use App\Models\City;
use App\Models\Trip;
use Database\Factories\CityFactory;
use Laravel\Lumen\Testing\DatabaseMigrations;

class BookingTest extends TestCase
{
    use DatabaseMigrations;

    public function createTrip()
    {
        $cities = City::factory()->count(2)->create()->toArray();
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
        $this->bookTickets(3,$tripId);
        $this->assertResponseStatus(201);
    }

    public function test_that_cancel_booking_trip_works_succesfully()
    {
        $tripId= $this->createTrip()->response->json()['trip']['id'];
        $ticketId = $this->bookTickets(4,$tripId)->response->json()['ticket']['id'];
        $this->post('/ticket/cancel',[
            'spots_to_cancel'=>2,
            'ticket_id'=>$ticketId,
        ]);
        $this->assertResponseStatus(200);

        # code...
    }

    private function bookTickets(int $count,int $tripId){
        
        return $this->post('/ticket/book',[
            'number_of_seats'=>$count,
            'trip_id'=>$tripId,
            'name'=>'ahmed',
            'email'=>'baaaal@caaa'
        ]);
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
