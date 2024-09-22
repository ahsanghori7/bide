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
        Schema::table('educational_assessments', function (Blueprint $table) {
            $table->date('assessment_date')->default(now())->after('appointment_id');
            $table->string('element_id')->nullable()->after('question_id');
            $table->string('element_value')->nullable()->after('element_id');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('educational_assessments', function (Blueprint $table) {
            $table->dropColumn('assessment_date');
            $table->dropColumn('element_id');
            $table->dropColumn('element_value');
        });
    }
};
