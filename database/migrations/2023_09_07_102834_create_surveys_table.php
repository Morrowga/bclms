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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->enum('type', ['USERREXP', 'PROFILING']);
            $table->enum('user_type', ['BC STAFF', 'ORG_TEACHER', 'B2C_USER']);
            $table->enum('appear_on', ['LOG_IN', 'LOG_OUT', 'BOOK_END', 'GAME_END']);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('required');
            $table->boolean('repeat');
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
        Schema::dropIfExists('surveys');
    }
};
