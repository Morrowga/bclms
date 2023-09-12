<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_themes', function (Blueprint $table) {
            $table->id();
            $table->enum('skins', ['default', 'bordered'])->default("default");
            $table->enum('themes', ['system', 'dark', 'light'])->default('system');
            $table->string('primary_color')->default("primary");
            $table->string('secondary_color')->default("primary");
            $table->enum('content_with', ['fluid', 'boxed'])->default("fluid");
            $table->enum('header_type', ['sticky', 'static'])->default("sticky");
            $table->enum('footer_type', ['sticky', 'static', 'hidden'])->default("sticky");
            $table->enum('menu_type', ['vertical', 'horizontal'])->default("horizontal");
            $table->timestamps();
        });

        DB::table('system_themes')->insert([
            'skins' => 'default',
            "themes" => 'system',
            "primary_color" => 'primary',
            "secondary_color" => 'primary',
            "content_with" => 'fluid',
            "header_type" => 'sticky',
            "footer_type" => 'sticky',
            "menu_type" => 'horizontal',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_themes_tables');
    }
};
