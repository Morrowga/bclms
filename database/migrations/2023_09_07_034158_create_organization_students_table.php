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
        Schema::create('organization_students', function (Blueprint $table) {
            $table->foreignId('student_id')->nullable()->references('student_id')->on('students')->cascadeOnDelete();
            $table->foreignId('organization_id')->nullable()->references('id')->on('organizations')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_students');
    }
};
