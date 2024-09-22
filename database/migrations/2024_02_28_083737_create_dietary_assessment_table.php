<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDietaryAssessmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dietary_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->unsignedBigInteger('meal_entries_id')->nullable();
            $table->integer('fats_intake')->nullable();
            $table->integer('calories_intake')->nullable();
            $table->integer('calories_required')->nullable();
            $table->integer('calories_advised')->nullable();
            $table->string('activity_factor')->nullable();
            $table->string('injury_factor')->nullable();
            $table->string('compliance')->nullable();
            $table->integer('visit_no')->nullable();
            $table->integer('protein_intake')->nullable();
            $table->integer('sodium_intake')->nullable();
            $table->string('remarks')->nullable();

            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('meal_entries_id')->references('id')->on('meal_entries')->onDelete('cascade')->onUpdate('restrict');
            // Inside the dietary_assessments migration file

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
        Schema::dropIfExists('dietary_assessment');
    }
}
