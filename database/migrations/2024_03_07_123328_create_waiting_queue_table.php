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
        Schema::create('waiting_queues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('clinic_user_id');
            $table->enum('status', ['added', 'moved'])->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patient_info')->onDelete('cascade')->onUpdate('restrict');
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
        Schema::dropIfExists('waiting_queues');
    }
};
