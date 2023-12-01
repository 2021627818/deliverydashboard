<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('postalcodes', function (Blueprint $table) {
            $table->id('postal_code');
            $table->foreignId('hub_id')->constrained('courierhubs', 'hub_id')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('postalcodes');
    }
};
