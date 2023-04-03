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
        Schema::create('student_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->nullable()->references('id')->on('students')->cascadeOnDelete();
            $table->foreignId('storybook_id')->nullable()->references('id')->on('storybooks')->cascadeOnDelete();
            $table->integer('progress')->nullable();
            $table->integer('final_score')->nullable();
            $table->integer('total_taps')->nullable();
            $table->integer('star_attained')->nullable();
            $table->string('outcome')->nullable();
            $table->json('activity_data')->nullable();
            $table->string('remark')->nullable();
            $table->enum('status', [0, 1])->default(0);
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
        Schema::dropIfExists('student_records');
    }
};
