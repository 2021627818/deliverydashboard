<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orderstatus', function (Blueprint $table) {
            $table->id('status_id');
            $table->string('status')->nullable();
            $table->foreignId('order_id')->constrained('orders', 'order_id')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orderstatus');
    }
};
