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
        Schema::create('storybook_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storybook_version_id')
                ->references('id')
                ->on('storybook_versions')->onDelete('cascade');
            $table->foreignId('student_id')
                ->references('student_id')
                ->on('students')->onDelete('cascade');
            $table->bigInteger('curr_timestamp')->default(0);
            $table->boolean('completed_once');
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
        Schema::dropIfExists('storybook_assignments');
    }
};
