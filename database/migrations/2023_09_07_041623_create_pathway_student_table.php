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
        Schema::create('pathway_student', function (Blueprint $table) {
            $table->foreignId('student_id')->nullable()->references('student_id')->on('students')->cascadeOnDelete();
            $table->foreignId('pathway_id')->nullable()->references('id')->on('pathways')->cascadeOnDelete();
            $table->string('progress')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pathway_student');
    }
};
