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
        Schema::table('meal_entries', function (Blueprint $table) {
            $table->integer('cereal_misc')->nullable()->after('protein');
            $table->integer('fats_misc')->nullable()->after('cereal_misc');
            $table->integer('calories_misc')->nullable()->after('fats_misc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meal_entries', function (Blueprint $table) {
            $table->dropColumn('cereal_misc');
            $table->dropColumn('fats_misc');
            $table->dropColumn('calories_misc');
        });
    }
};
