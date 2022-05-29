<?php

namespace Tests;

use App\Models\City;
use Database\Factories\CityFactory;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TripCreationTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * Undocumented function
     *
     * @param [int] $count
     * @return array
     */
    private function makeCities(int $count): array{
        return City::factory()->count($count)->create()->toArray();
       
    }
    private function createTrip()
    {
        $cities = $this->makeCities(2);
        $derpartureTime = time()+3600;
        $arrivalTime = $derpartureTime+12000;
        return $this->post('/trips',[
            'number_of_spots'=>15,
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
    public function test_that_base_trip_creation_returns_successful_response()
    {
        $this->createTrip();
        $this->assertResponseStatus(201);
    }

     /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_base_trip_creation_returns_failure_for_negative_spots_number_response()
    {
        $cities = $cities = $this->makeCities(2);
        $derpartureTime = time()+3600;
        $arrivalTime = $derpartureTime+12000;
        $this->post('/trips',[
            'number_of_spots'=>-15,
            'from'=>$cities[0]['name'],
            'to'=>$cities[1]['name'],
            'price'=>10.2,
            'derparture_time'=>date('d-m-y h:m',$derpartureTime),
            'arrival_time'=>date('d-m-y h:m',$arrivalTime)
             /* adding two minutes buffer*/ 
        ]);
        $this->assertResponseStatus(422);
    }

        /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_base_trip_creation_returns_failure_for_negative_price_response()
    {
        $cities = $cities = $this->makeCities(2);
        $derpartureTime = time()+3600;
        $arrivalTime = $derpartureTime+12000;
        $this->post('/trips',[
            'number_of_spots'=>15,
            'from'=>$cities[0]['name'],
            'to'=>$cities[1]['name'],
            'price'=>-10.2,
            'derparture_time'=>date('d-m-y h:m',$derpartureTime),
            'arrival_time'=>date('d-m-y h:m',$arrivalTime)
             /* adding two minutes buffer*/ 
        ]);
        $this->assertResponseStatus(422);
    }
 /**
     * test_that_base_trip_creation_returns_failure_for_same_city_in_from_and_to_response
     *
     * @return void
     */
    public function test_that_base_trip_creation_returns_failure_for_same_city_in_from_and_to_response()
    {
        $cities = $cities = $this->makeCities(2);
        $derpartureTime = time()+3600;
        $arrivalTime = $derpartureTime+12000;
        $this->post('/trips',[
            'number_of_spots'=>-15,
            'from'=>'blabab',
            'to'=>$cities[1]['name'],
            'price'=>10.2,
            'derparture_time'=>date('d-m-y h:m',$derpartureTime),
            'arrival_time'=>date('d-m-y h:m',$arrivalTime)
             /* adding two minutes buffer*/ 
        ]);
        $this->assertResponseStatus(422);
    }
    /**
     * test_that_base_trip_creation_returns_failure_for_same_city_in_from_and_to_response
     *
     * @return void
     */
    public function test_that_base_trip_creation_returns_failure_for_invalid_cities_in_from_number_response()
    {
        $cities = $this->makeCities(2);
        $derpartureTime = time()+3600;
        $arrivalTime = $derpartureTime+12000;
        $this->post('/trips',[
            'number_of_spots'=>-15,
            'from'=>'blabab',
            'to'=>$cities[1]['name'],
            'price'=>10.2,
            'derparture_time'=>date('d-m-y h:m',$derpartureTime),
            'arrival_time'=>date('d-m-y h:m',$arrivalTime)
             /* adding two minutes buffer*/ 
        ]);
        $this->assertResponseStatus(422);
    }
    /**
     * test_that_base_trip_creation_returns_failure_for_same_city_in_from_and_to_response
     *
     * @return void
     */
    public function test_that_base_trip_creation_returns_failure_for_invalid_cities_in_to_number_response()
    {
        $cities = $cities = $this->makeCities(2);
        $derpartureTime = time()+3600;
        $arrivalTime = $derpartureTime+12000;
        $this->post('/trips',[
            'number_of_spots'=>-15,
            'from'=>$cities[1]['name'],
            'to'=>'sfsdfsfs',
            'price'=>10.2,
            'derparture_time'=>date('d-m-y h:m',$derpartureTime),
            'arrival_time'=>date('d-m-y h:m',$arrivalTime)
             /* adding two minutes buffer*/ 
        ]);
        $this->assertResponseStatus(422);
    }
    
}
