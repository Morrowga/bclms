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
        Schema::create('student_learning_needs', function (Blueprint $table) {
            $table->foreignId('student_id')->nullable()->references('student_id')->on('students')->cascadeOnDelete();
            $table->foreignId('sub_learning_type_id')->nullable()->references('id')->on('sub_learning_types')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_learning_needs');
    }
};
