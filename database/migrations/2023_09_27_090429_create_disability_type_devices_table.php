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
        Schema::create('disability_type_devices', function (Blueprint $table) {

            $table->foreignId('disability_type_id')
                ->references('id')
                ->on('disability_types')->onDelete('cascade');
            $table->foreignId('device_id')
                ->references('id')
                ->on('devices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disability_type_devices');
    }
};
