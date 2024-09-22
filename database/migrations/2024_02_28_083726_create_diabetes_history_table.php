<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiabetesHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diabetes_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->string('type')->nullable();
            $table->integer('year_diagnosed')->nullable();
            $table->boolean('insulin')->default(false);
            $table->text('insulin_details')->nullable();
            $table->boolean('keto_diagnosis')->default(false);
            $table->text('keto_details')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('patient_id')->references('id')->on('patient_info')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diabetes_history');
    }
}
