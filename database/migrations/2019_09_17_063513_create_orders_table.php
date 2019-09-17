<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status')->nullable();
            $table->boolean('is_guest')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_first_name')->nullable();
            $table->string('customer_last_name')->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('shipping_title')->nullable();
            $table->string('shipping_description')->nullable();
            $table->unsignedInteger('total_item_count')->nullable();
            $table->unsignedInteger('total_qty_ordered')->nullable();
            $table->decimal('grand_total',12,4)->nullable()->default(0);
            $table->decimal('base_grand_total', 12,4)->nullable()->default(0);
            $table->decimal('sub_total',12,4)->nullable()->default(0);
            $table->decimal('base_sub_total')->nullable()->default(0);
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
        Schema::dropIfExists('orders');
    }
}
