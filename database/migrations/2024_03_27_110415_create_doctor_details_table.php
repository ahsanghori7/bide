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
        Schema::create('doctor_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id')->unsigned()->nullable();
            $table->bigInteger('assigned_calls')->unsigned()->nullable();
            $table->string('prefix', 20)->nullable();
            $table->integer('experience_year')->nullable();
            $table->string('cnic', 255)->nullable();
            $table->string('pmc_no', 12)->nullable();
            $table->string('badge', 20)->nullable();
            $table->text('about')->nullable();
            $table->double('waiting_time')->nullable();
            $table->string('visiting_card_image', 255)->nullable();
            $table->tinyInteger('is_instant_consultation')->default(0);
            $table->tinyInteger('is_available')->default(0);
            $table->tinyInteger('profile_status')->default(1);
            $table->text('collaborations')->nullable();
            $table->text('image')->nullable();
            $table->string('consultation_duration', 50)->nullable();
            $table->tinyInteger('is_physical_consultancy')->default(0);
            $table->tinyInteger('is_video_consultancy')->default(0);
            $table->tinyInteger('is_voice_consultancy')->default(0);
            $table->integer('current_appointment')->nullable();
            $table->timestamp('last_call_at')->nullable();
            $table->tinyInteger('is_login_credentials_sent')->default(0);
            $table->integer('shift_id')->nullable();
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('is_verified')->default(0);
            $table->tinyInteger('is_admin_verified')->default(0);

            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('restrict');
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
        Schema::dropIfExists('doctor_details');
    }
};
