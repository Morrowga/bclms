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
        Schema::create('storybooks_devices', function (Blueprint $table) {
            $table->foreignId('storybook_id')->nullable()->references('id')->on('storybooks')->cascadeOnDelete();
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
        Schema::dropIfExists('storybooks_devices');
    }
};
