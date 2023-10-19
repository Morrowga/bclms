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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->string('ssl')->nullable()->default('Default SSL');
            $table->string('site_time_zone')->nullable();
            $table->string('site_locale')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('url')->nullable();
            $table->string('website_logo')->nullable();
            $table->string('website_favicon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_settings');
    }
};
