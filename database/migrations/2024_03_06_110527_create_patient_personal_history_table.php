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
        Schema::create('patient_personal_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed']);
            $table->unsignedBigInteger('occupation')->nullable();
            $table->unsignedBigInteger('lifestyle')->nullable();
            $table->boolean('father_diabetic')->nullable();
            $table->boolean('mother_diabetic')->nullable();
            $table->boolean('spouse_diabetic')->nullable();
            $table->boolean('brother_diabetic')->nullable();
            $table->boolean('sister_diabetic')->nullable();
            $table->boolean('children_diabetic')->nullable();
            $table->boolean('live_birth')->nullable();
            $table->boolean('still_birth')->nullable();
            $table->boolean('neonatal_deaths')->nullable();
            $table->boolean('abortion')->nullable();

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
        Schema::dropIfExists('patient_personal_history');
    }
};
