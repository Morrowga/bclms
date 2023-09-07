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
        Schema::create('classroom_teachers', function (Blueprint $table) {
            $table->foreignId('classroom_id')->nullable()->references('id')->on('classrooms')->cascadeOnDelete();
            $table->foreignId('teacher_id')->nullable()->references('id')->on('b2b_users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classroom_teachers');
    }
};
