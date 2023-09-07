<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disability_types_devices', function (Blueprint $table) {
            $table->foreignId('disability_type_id')->nullable()->references('id')->on('disability_types')->cascadeOnDelete();
            $table->foreignId('device_id')->nullable()->references('id')->on('devices')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disability_types_devices');
    }
};
