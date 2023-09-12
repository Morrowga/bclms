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
        Schema::create('storybook_disability_types', function (Blueprint $table) {
            $table->foreignId('storybook_id')->nullable()->references('id')->on('storybooks')->cascadeOnDelete();
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
        Schema::dropIfExists('storybook_disability_types');
    }
};