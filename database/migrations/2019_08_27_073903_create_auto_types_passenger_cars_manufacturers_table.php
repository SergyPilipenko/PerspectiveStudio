<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoTypesPassengerCarsManufacturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_types_passenger_cars_manufacturers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('auto_type_id');
            $table->foreign('auto_type_id')->references('id')->on('auto_types');
            $table->bigInteger('manufacturer_id');
            $table->foreign('manufacturer_id')->references('id')->on(env('DB_TECDOC_DATABASE').'.manufacturers');
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
        Schema::dropIfExists('auto_types_passenger_cars_manufacturers');
    }
}
