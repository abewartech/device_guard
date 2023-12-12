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
        Schema::create('usb_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('busNumber')->nullable();
            $table->unsignedInteger('deviceAddress')->nullable();
            $table->unsignedInteger('vendorId')->nullable();
            $table->unsignedInteger('productId')->nullable();
            $table->string('macAddress')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usb_devices');
    }
};
