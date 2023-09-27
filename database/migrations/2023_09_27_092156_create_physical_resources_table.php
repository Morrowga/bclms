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
        Schema::create('physical_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storybook_id')
                ->references('id')
                ->on('storybooks')->onDelete('cascade');
            $table->string('file_src');
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
        Schema::dropIfExists('physical_resources');
    }
};
