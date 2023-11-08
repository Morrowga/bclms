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
        Schema::create('game_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->nullable()
            ->references('id')
            ->on('games')->onDelete('cascade');
            $table->foreignId('student_id')->nullable()
            ->references('student_id')
            ->on('students')->onDelete('cascade');
            $table->float('score', 5, 2)->default(0.0);
            $table->float('accuracy', 5, 2)->default(0.0);
            $table->float('duration', 5, 2)->default(0.0);
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
        Schema::dropIfExists('game_assignments');
    }
};
