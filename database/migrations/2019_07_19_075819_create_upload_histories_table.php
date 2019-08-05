<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('price_upload_success_count');
            $table->bigInteger('price_upload_fails_count');
            $table->bigInteger('import_setting_id');
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
        Schema::dropIfExists('upload_histories');
    }
}
