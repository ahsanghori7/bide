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
        Schema::create('educator_queues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('appointment_id');
            $table->unsignedBigInteger('clinic_user_id');
            $table->string('status')->nullable();
            $table->foreign('patient_id')->references('id')->on('patient_info')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('clinic_user_id')->references('id')->on('clinic_user')->onDelete('cascade')->onUpdate('restrict');
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
        Schema::dropIfExists('educator_queue');
    }
};
