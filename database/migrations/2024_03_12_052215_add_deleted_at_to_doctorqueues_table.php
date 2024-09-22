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
        Schema::table('doctor_queues', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('educator_queues', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('waiting_queues', function (Blueprint $table) {
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
        Schema::table('doctorqueues', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('educator_queues', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('waiting_queues', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
