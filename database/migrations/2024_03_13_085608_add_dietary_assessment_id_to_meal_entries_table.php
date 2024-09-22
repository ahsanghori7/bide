<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDietaryAssessmentIdToMealEntriesTable extends Migration
{
    public function up()
    {
        Schema::table('meal_entries', function (Blueprint $table) {
            $table->unsignedBigInteger('dietary_assessment_id')->nullable();
            $table->foreign('dietary_assessment_id')->references('id')->on('dietary_assessments')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('meal_entries', function (Blueprint $table) {
            $table->dropForeign(['dietary_assessment_id']);
            $table->dropColumn('dietary_assessment_id');
        });
    }
}
