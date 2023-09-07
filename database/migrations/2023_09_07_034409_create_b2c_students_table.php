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
        Schema::create('b2c_students', function (Blueprint $table) {
            $table->foreignId('student_id')->nullable()->references('student_id')->on('students')->cascadeOnDelete();
            $table->foreignId('b2c_user_id')->nullable()->references('id')->on('b2c_users')->cascadeOnDelete();

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
        Schema::dropIfExists('b2c_students');
    }
};
