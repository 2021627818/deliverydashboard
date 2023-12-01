<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->date('order_date')->nullable();
            $table->string('descriptions')->nullable();
            $table->string('parcel_weight')->nullable();
            $table->string('parcel_length')->nullable();
            $table->string('parcel_width')->nullable();
            $table->string('parcel_height')->nullable();
            $table->foreignId('customers_id')->constrained('customer_profiles', 'customer_id')->onUpdate('cascade')->nullable();
            $table->foreignId('start_hub_id')->constrained('courierhubs', 'hub_id')->onUpdate('cascade')->nullable();
            $table->foreignId('end_hub_id')->constrained('courierhubs', 'hub_id')->onUpdate('cascade')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
