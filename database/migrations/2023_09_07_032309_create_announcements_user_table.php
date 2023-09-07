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
        Schema::create('announcements_user', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()
                ->references('id')
                ->on('users')->onDelete('cascade');
            $table->foreignId('announcement_id')->nullable()
                ->references('id')
                ->on('announcements')->onDelete('cascade');
            $table->boolean('has_clear');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcements_user');
    }
};
