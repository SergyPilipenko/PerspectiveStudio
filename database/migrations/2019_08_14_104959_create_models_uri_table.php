<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsUriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models_uri', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('model_id');
            $table->foreign('model_id')
                ->references('id')
                ->on(env('DB_TECDOC_DATABASE').'.'.'models')
                ->onDelete('restrict');
            $table->string('slug');
            $table->bigInteger('manufacturer_id');
            $table->foreign('manufacturer_id')
                ->references('id')
                ->on(env('DB_TECDOC_DATABASE').'.'.'manufacturers')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('models_uri');
    }
}
