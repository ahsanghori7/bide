<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remarks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->text('general_remarks')->nullable();
            $table->text('dietary_remarks')->nullable();
            $table->text('prescription_remarks')->nullable();
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('patient_id')->references('id')->on('patient_info');
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
        Schema::dropIfExists('remarks');
    }
}
