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
        Schema::table('storybook_versions', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->after('teacher_id')
                ->references('parent_id')
                ->on('parents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('storybook_versions', function (Blueprint $table) {
            //
        });
    }
};
