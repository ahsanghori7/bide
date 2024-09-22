<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vitals', function (Blueprint $table) {
            // basic details of the patient
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->float('heart_rate')->nullable();
            $table->float('blood_pressure_systolic')->nullable();
            $table->float('blood_pressure_diastolic')->nullable();
            $table->float('glucometer_result')->nullable();
            $table->float('bmi')->nullable();
            $table->float('temperature')->nullable();
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('patient_id')->references('id')->on('patient_info')->onDelete('cascade')->onUpdate('restrict');
        });



        // Add more sample data as needed
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vitals');
    }
}
