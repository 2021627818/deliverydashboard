<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_address', function (Blueprint $table) {
            $table->id('address_id');
            $table->foreignId('customer_id')->constrained('customer_profiles', 'customer_id')->onDelete('cascade')->onUpdate('cascade')->nullable(); // foreign key to customer_profiles table
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->unsignedInteger('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_address');
    }
};
