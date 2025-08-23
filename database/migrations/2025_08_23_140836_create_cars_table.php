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
        Schema::create('cars', function (Blueprint $table) {
            $table->id()->comment('Primary key');
            $table->unsignedBigInteger('model_id')->comment('Reference to car_models.id');
            $table->foreign('model_id')->references('id')->on('car_models');
            $table->year('year')->nullable()->comment('Year of manufacture');
            $table->unsignedMediumInteger('mileage')->nullable()->comment('Car mileage');
            $table->string('color', 32)->nullable()->comment('Car color');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
