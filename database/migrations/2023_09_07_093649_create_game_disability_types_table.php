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
        Schema::create('game_disability_types', function (Blueprint $table) {
            $table->foreignId('game_id')->nullable()->references('id')->on('games')->cascadeOnDelete();
            $table->foreignId('disability_type_id')->nullable()->references('id')->on('disability_types')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_disability_types');
    }
};
