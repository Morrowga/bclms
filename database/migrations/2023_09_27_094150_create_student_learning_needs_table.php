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
            $table->foreignId('student_id')
                ->references('student_id')
                ->on('students')->onDelete('cascade');
            $table->foreignId('sub_learning_type_id')
                ->references('id')
                ->on('sub_learning_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_learnings_needs');
    }
};
