<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\City;

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
            $table->foreignIdFor(City::class,'soure_city_id');
            $table->foreignIdFor(City::class,'destination_city_id');
            $table->unsignedBigInteger('city_city_id');
            $table->unsignedDecimal('number_of_seats');
            $table->unsignedDecimal('remaining_seats');
            $table->double('ticket_price');
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
