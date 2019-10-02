<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManufacturersUriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manufacturers_uri', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('manufacturer_id');
            $table->foreign('manufacturer_id')
                ->references('id')
                ->on(env('DB_TECDOC_DATABASE').'.'.'manufacturers')
                ->onDelete('restrict');
            $table->string('slug')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manufacturers_uri');
    }
}
