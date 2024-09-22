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
        Schema::table('patient_personal_history', function (Blueprint $table) {
            $table->float('father_diabetic_text')->nullable();
            $table->float('mother_diabetic_text')->nullable();
            $table->float('spouse_diabetic_text')->nullable();
            $table->float('brother_diabetic_text')->nullable();
            $table->float('sister_diabetic_text')->nullable();
            $table->float('children_diabetic_text')->nullable();
            $table->float('live_birth_text')->nullable();
            $table->float('still_birth_text')->nullable();
            $table->float('neonatal_deaths_text')->nullable();
            $table->float('abortiont_ext')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_personal_history', function (Blueprint $table) {
            $table->dropColumn('father_diabetic_text');
            $table->dropColumn('mother_diabetic_text');
            $table->dropColumn('spouse_diabetic_text');
            $table->dropColumn('brother_diabetic_text');
            $table->dropColumn('sister_diabetic_text');
            $table->dropColumn('children_diabetic_text');
            $table->dropColumn('live_birth_text');
            $table->dropColumn('still_birth_text');
            $table->dropColumn('neonatal_deaths_text');
            $table->dropColumn('abortiont_ext');
        });
    }
};
