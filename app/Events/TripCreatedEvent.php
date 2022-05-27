<?php

namespace App\Events;

use App\Models\Trip;

class TripCreatedEvent extends Event
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public Trip $trip)
    {
        //
    }
}
