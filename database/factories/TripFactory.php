<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Spot;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class CityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trip::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number_of_spots' => $this->faker->numberBetween(0,100),
            'price'=>$this->faker->numberBetween(0,30),
            'city_source_id'=>City::factory()->make(1),
            'city_destination_id'=>City::factory()->make(1),
        ];
    }
}
