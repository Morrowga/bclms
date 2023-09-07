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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('current_subscription_id')->nullable()->references('id')->on('subscriptions')->cascadeOnDelete();
            $table->foreignId('org_admin_id')->nullable()->references('id')->on('users')->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->integer('contact_number')->nullable();
            $table->foreignId('tenant_id')->nullable(); //tenant_id as sub_domain
            $table->string('logo')->nullable();
            $table->enum('status', ['ACTIVE', 'INACTIVE']);
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
        Schema::dropIfExists('organizations');
    }
};
