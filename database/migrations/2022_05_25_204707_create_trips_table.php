<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\City;
use App\Models\Trip;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(City::class,'from_city_id');
            $table->foreignIdFor(City::class,'to_city_id');
            $table->unsignedInteger('number_of_spots');
            $table->unsignedInteger('remaining_spots');
            $table->double('ticket_price');
            $table->enum('status',Trip::STATUSES)->default(Trip::PENDING);
            $table->timestamp('derpature_time');
            $table->timestamp('arrival_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
};
