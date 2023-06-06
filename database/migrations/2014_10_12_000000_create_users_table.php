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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('date_of_birth')->nullable();
            $table->string('avatar')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_online')->default(false);
            $table->timestamp('last_online_at')->nullable();
            $table->string('role_code')->nullable();
            $table->foreign('role_code')
                ->references('role_code')
                ->on('roles')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->string('position_code')->nullable();
            $table->foreign('position_code')
                ->references('position_code')
                ->on('positions')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
