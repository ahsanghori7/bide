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
        Schema::table('prescribed_elements', function (Blueprint $table) {
            $table->boolean('is_before_meal')->nullable()->after('is_after_meal');
            $table->integer('morning')->nullable()->after('is_before_meal');
            $table->integer('noon')->nullable()->after('morning');
            $table->integer('evening')->nullable()->after('noon');
            $table->integer('night')->nullable()->after('evening');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prescribed_elements', function (Blueprint $table) {
            $table->dropColumn('is_before_meal');
            $table->dropColumn('morning');
            $table->dropColumn('night');
            $table->dropColumn('evening');
            $table->dropColumn('noon');
        });
    }
};
