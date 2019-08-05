<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

class CreateDistinctPassangerCarTreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distinct_passanger_car_trees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('searchtreeid');
            $table->unsignedBigInteger('passanger_car_trees_id');
            $table->unsignedBigInteger('passanger_car_trees_parentid');
            NestedSet::columns($table);
            $table->string('description');
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
        Schema::dropIfExists('distinct_passanger_car_trees');
    }
}
