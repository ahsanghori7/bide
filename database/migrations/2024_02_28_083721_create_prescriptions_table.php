<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('prescriptions')) {
            Schema::create('prescriptions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('appointment_id');
                $table->text('consultation_note')->nullable();
                $table->text('patient_consultation_note')->nullable();
                $table->tinyInteger('status');
                $table->timestamp('deleted_at')->nullable();
                $table->timestamps();

                $table->foreign('appointment_id')->references('id')->on('appointments');
            });
        }
        // Add more sample data as needed
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescriptions');
    }
}
