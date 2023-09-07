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
        Schema::create('playlist_storybook', function (Blueprint $table) {
            $table->foreignId('playlist_id')->nullable()->references('id')->on('playlists')->cascadeOnDelete();
            $table->foreignId('storybook_id')->nullable()->references('id')->on('storybooks')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('playlist_storybook');
    }
};
