<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courierhubs', function (Blueprint $table) {
            $table->id('hub_id');
            $table->string('hub_city');
            $table->string('hub_state');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courierhubs');
    }
};
