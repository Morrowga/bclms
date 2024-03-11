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
        Schema::table('storybook_assignments', function (Blueprint $table) {
            $table->float('score', 5, 2)->default(0.0);
            $table->float('accuracy', 5, 2)->default(0.0);
            $table->float('duration', 5, 2)->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('storybook_assignments', function (Blueprint $table) {
            $table->dropColumn('score');
            $table->dropColumn('accuracy');
            $table->dropColumn('duration');
        });
    }
};
