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
        Schema::table('dietary_assessments', function (Blueprint $table) {
            $table->float('bmi')->after('remarks');
            $table->float('ibw')->after('bmi');
            $table->float('bee')->after('ibw');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dietary_assessments', function (Blueprint $table) {
            $table->dropColumn('bmi');
            $table->dropColumn('ibw');
            $table->dropColumn('bee');
        });
    }
};
