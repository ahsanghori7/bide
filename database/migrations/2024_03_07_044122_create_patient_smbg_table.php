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
        Schema::create('smbgs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->float('pre_breakfast')->nullable();
            $table->float('post_breakfast')->nullable();
            $table->float('pre_lunch')->nullable();
            $table->float('post_lunch')->nullable();
            $table->float('pre_dinner')->nullable();
            $table->float('post_dinner')->nullable();
            $table->float('before_bed')->nullable();
            $table->float('random')->nullable();
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
        Schema::dropIfExists('patient_smbg');
    }
};
