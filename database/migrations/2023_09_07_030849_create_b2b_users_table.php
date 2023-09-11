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
        Schema::create('b2b_users', function (Blueprint $table) {
            $table->id('b2b_user_id');
            $table->foreignId('user_id')->nullable()
                ->references('id')
                ->on('users')->onDelete('cascade');
            $table->foreignId('organization_id')->nullable()
                ->references('id')
                ->on('organizations')->onDelete('cascade');
            $table->decimal('allocated_storage_limit', 10, 1);
            $table->boolean('has_full_library_access');
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
        Schema::dropIfExists('b2b_users');
    }
};
