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
        Schema::table('storybooks', function (Blueprint $table) {
            $table->enum('type', ['HTML5', 'H5P'])->default('H5P')->after('h5p_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('storybooks', function (Blueprint $table) {
            // $table->enum('type', ['HTML5', 'H5P'])->default('H5P')->after('h5p_id');
        });
    }
};
