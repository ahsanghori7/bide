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
        Schema::table('doctor_educations', function (Blueprint $table) {
            $table->foreign('degree')->references('id')->on('degrees')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('institute')->references('id')->on('universities')->onDelete('cascade')->onUpdate('restrict');
        });

        Schema::table('doctor_experiences', function (Blueprint $table) {
            $table->foreign('institute')->references('id')->on('universities')->onDelete('cascade')->onUpdate('restrict');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('clinic_user_id')->references('id')->on('clinic_user')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor_educations', function (Blueprint $table) {
            $table->dropForeign(['degree']);
        });

        Schema::table('doctor_experiences', function (Blueprint $table) {
            $table->dropForeign(['institute']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['clinic_user_id']);
        });
    }
};
