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
        Schema::create('student_disability_types', function (Blueprint $table) {
            $table->foreignId('student_id')->nullable()->references('student_id')->on('students')->cascadeOnDelete();
            $table->foreignId('disability_type_id')->nullable()->references('id')->on('disability_types')->cascadeOnDelete();
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
        Schema::dropIfExists('student_disability_types');
    }
};
