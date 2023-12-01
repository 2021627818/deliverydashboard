<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('couriers', function (Blueprint $table) {
            $table->id('courier_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->foreignId('hub_id')->constrained('courierhubs', 'hub_id')->onUpdate('cascade')->nullable();
            $table->foreignId('user_id')->constrained('users', 'id')->onUpdate('cascade')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('couriers');
    }
};
