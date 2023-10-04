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
        Schema::create('storybook_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storybook_id')
                ->references('id')
                ->on('storybooks')->onDelete('cascade');
            $table->foreignId('teacher_id')
                ->nullable()
                ->references('teacher_id')
                ->on('teachers')->onDelete('cascade');
            $table->foreignId('h5p_id')->nullable()
                ->references('id')
                ->on('h5p_contents')->onDelete('cascade');
            $table->string('name');
            $table->longText('description');
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
        Schema::dropIfExists('storybook_versions');
    }
};
