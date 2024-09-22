<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    public function up()
    {
        Schema::create('patient_info', function (Blueprint $table) {
            $table->id();
            $table->integer('mr_no')->unique();
            $table->string('name');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->date('date_of_birth');
            $table->string('cnic')->unique();
            $table->string('email')->nullable();
            $table->string('mobile_number');
            $table->string('telephone')->nullable();
            $table->text('address');
            $table->text('work_address')->nullable();
            $table->enum('ethnicity', ['Asian', 'African', 'Caucasian', 'Other']);
            $table->string('home_address')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patient_info');
    }
}
