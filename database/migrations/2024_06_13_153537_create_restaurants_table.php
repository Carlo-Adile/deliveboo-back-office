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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('contact_email')->nullable();
            $table->string('vat');
            $table->string('name_restaurant');
            $table->string('slug');
            $table->string('address');
            $table->string('phone_number')->nullable();
            $table->string('logo')->nullable();
            $table->string('thumb')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
