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
        Schema::create('users_announcements', function (Blueprint $table) {
            $table->foreignId('announcement_id')->nullable()
                ->references('id')
                ->on('announcements')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()
                ->references('id')
                ->on('users')->onDelete('cascade');
            $table->boolean('is_cleared');
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
        Schema::dropIfExists('users_announcements');
    }
};
