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
        if (Schema::hasColumn('patient_info', 'ethnicity')) {
            Schema::table('patient_info', function (Blueprint $table) {
                $table->dropColumn('ethnicity');
            });
        }

        Schema::table('patient_info', function (Blueprint $table) {
            $table->unsignedBigInteger('ethnicity')->nullable();
            $table->foreign('ethnicity')->references('id')->on('ethnicities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tinyint_in_patient_info', function (Blueprint $table) {
            //
        });
    }
};
