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
        Schema::create('games_tags', function (Blueprint $table) {
            $table->foreignId('game_id')->nullable()->references('id')->on('games')->cascadeOnDelete();
            $table->foreignId('tag_id')->nullable()->references('id')->on('tags')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games_tags');
    }
};
