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
        /*
        Schema::table('meal_entries', function (Blueprint $table) {
            $table->unsignedBigInteger('dietary_assessments_id');
            // Add foreign key constraint
            $table->foreign('dietary_assessments_id')->references('id')->on('dietary_assessments');
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
