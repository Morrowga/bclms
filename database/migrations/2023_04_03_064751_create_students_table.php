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
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('student_id');
            $table->foreignId('organization_id')->nullable()->references('id')->on('organizations')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('device_id')->nullable()->references('id')->on('devices')->cascadeOnDelete();
            $table->string('gender');
            $table->string('dob')->nullable();
            $table->string('education_level')->nullable();
            $table->integer('num_gold_coins')->default(0);
            $table->integer('num_silver_coins')->default(0);
            $table->string('student_code')->nullable();
            $table->float('total_time_spent');
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
        Schema::dropIfExists('students');
    }
};
