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
            $table->string('description');
            $table->enum('type', [
                'USEREXP', 'PROFILING'
            ]);
            $table->enum('appear_on',[
                'LOG_IN',
                'LOG_OUT',
                'BOOK_END',
                'GAME_END'
            ]);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->date('date_created');
            $table->boolean('required')->default(false);
            $table->boolean('repeat')->default(false);
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
