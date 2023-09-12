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
        Schema::create('b2b_subscriptions', function (Blueprint $table) {
            $table->foreignId('subscription_id')->nullable()
                ->references('id')
                ->on('subscriptions')->onDelete('cascade');
            $table->foreignId('organization_id')->nullable()
                ->references('id')
                ->on('organizations')->onDelete('cascade');
            $table->string('receipt_image')->nullable();
            $table->float('storage_limit');
            $table->integer('num_teacher_license');
            $table->integer('num_student_license');
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
        Schema::dropIfExists('b2b_subscriptions');
    }
};
