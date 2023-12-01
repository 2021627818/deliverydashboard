<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recipients', function (Blueprint $table) {
            $table->id('recipient_id');
            $table->string('recipient_first_name')->nullable();
            $table->string('recipient_last_name')->nullable();
            $table->string('recipient_phone_number')->nullable();
            $table->string('recipient_address_line1')->nullable();
            $table->string('recipient_address_line2')->nullable();
            $table->string('recipient_postal_code')->nullable();
            $table->string('recipient_state')->nullable();
            $table->string('recipient_city')->nullable();
            $table->string('recipient_country');
            $table->foreignId('order_id')->constrained('orders', 'order_id')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipients');
    }
};
