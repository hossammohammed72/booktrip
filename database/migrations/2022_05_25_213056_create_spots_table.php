<?php

use App\Models\Trip;
use App\Models\Ticket;
use App\Models\Spot;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spots', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Trip::class,'trip_id');
            $table->foreignIdFor(Ticket::class,'ticket_id')->nullable();
            $table->unsignedDecimal('spot_number');
            $table->enum('status',Spot::STATUSES);
            $table->unique(['trip_id','spot_number']);
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
        Schema::dropIfExists('spots');
    }
};
