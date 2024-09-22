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
        Schema::create('patient_medical_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->boolean('previous_treat')->nullable();
            $table->string('previous_treat_text')->nullable();
            $table->boolean('eye_drop')->nullable();
            $table->string('eye_drop_text')->nullable();
            $table->boolean('walk')->nullable();
            $table->boolean('previous_medication')->nullable();
            $table->string('previous_medication_text')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patient_info')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_medical_history');
    }
};
