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
        Schema::create('lab_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->string('lab_name');
            $table->date('date');
            $table->float('fbs')->nullable();
            $table->float('rbs')->nullable();
            $table->float('hba1c')->nullable();
            $table->float('s_creatinine')->nullable();
            $table->smallInteger('urine_dr')->nullable();
            $table->float('microalbumin')->nullable();
            $table->smallInteger('tfh_u_protein')->nullable();
            $table->float('tfh_cct')->nullable();
            $table->smallInteger('total_lipid')->nullable();
            $table->smallInteger('cholesterol')->nullable();
            $table->smallInteger('triglyceride')->nullable();
            $table->smallInteger('ldl')->nullable();
            $table->smallInteger('hdl')->nullable();
            $table->smallInteger('ecg')->nullable();
            $table->smallInteger('ett')->nullable();
            $table->smallInteger('echo')->nullable();
            $table->float('t3')->nullable();
            $table->float('t4')->nullable();
            $table->float('tsh')->nullable();
            $table->smallInteger('cds')->nullable();
            $table->smallInteger('glucose')->nullable();
            $table->smallInteger('hbs')->nullable();
            $table->smallInteger('xray_chest')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patient_info')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lab_reports');
    }
};
