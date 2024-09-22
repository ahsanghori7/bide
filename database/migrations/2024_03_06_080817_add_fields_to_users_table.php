<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('role_id')->nullable();
            $table->bigInteger('city_id')->nullable();
            $table->string('otp', 10)->nullable();
            $table->timestamp('otp_expire')->nullable();
            $table->tinyInteger('is_blocked')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->tinyInteger('is_login')->nullable();
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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
