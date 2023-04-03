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
            $table->id();
            $table->foreignId('organization_id')->nullable()->references('id')->on('organizations')->cascadeOnDelete();
            $table->foreignId('device_id')->nullable()->references('id')->on('devices')->cascadeOnDelete();
            $table->string('student_code')->nullable();
            $table->string('name')->nullable();
            $table->string('nickname')->nullable();
            $table->longText('description')->nullable();
            $table->date('dob')->nullable();
            $table->string('grade')->nullable();
            $table->unsignedBigInteger('star_earn')->nullable();
            $table->unsignedBigInteger('coin_earn')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('students');
    }
};
