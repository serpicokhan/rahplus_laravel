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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->integer('driver_id')->unsigned()->default(0);
            $table->integer('service_id')->unsigned()->default(0);
            $table->integer('brand_id')->unsigned()->default(0);
            $table->integer('color_id')->unsigned()->default(0);
            $table->integer('year_id')->unsigned()->default(0);
            $table->integer('model_id')->unsigned()->default(0);
            $table->string('image')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->text('form_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
