<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('supplier_id');
            $table->float('price');
            $table->bigInteger('currency_id');
            $table->boolean('used')->default(false);
            $table->unsignedBigInteger('quantity')->nullable();
            $table->unsignedBigInteger('import_setting_id');
            $table->foreign('import_setting_id')->references('id')->on('import_settings');
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
        Schema::dropIfExists('prices');
    }
}
