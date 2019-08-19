<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvalidPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invalid_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('article');
            $table->string('supplier');
            $table->float('price');
            $table->bigInteger('available');
            $table->unsignedBigInteger('import_setting_id');
            $table->foreign('import_setting_id')
                ->references('id')->on('import_settings')->onDelete('restrict');
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
        Schema::dropIfExists('invalid_prices');
    }
}
