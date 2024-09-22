<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('appointments')) {
            Schema::create('appointments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('patient_id');
                $table->unsignedBigInteger('doctor_id');
                $table->string('user_agent')->nullable();
                $table->string('booked_via_subscription')->nullable();
                $table->integer('subscription_id')->nullable();
                $table->tinyInteger('is_patient_connected')->nullable();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('family_member_id')->nullable();
                $table->integer('consultation_fee')->nullable();
                $table->string('reason')->nullable();
                $table->string('type')->nullable();
                $table->enum('priority', ['high', 'medium', 'low'])->nullable();
                $table->date('date')->nullable();
                $table->time('time')->nullable();
                $table->string('progress')->nullable();
                $table->string('agora_link')->nullable();
                $table->bigInteger('action_by')->nullable();
                $table->tinyInteger('is_paid')->nullable();
                $table->tinyInteger('is_notified')->nullable();
                $table->enum('status', ['in-progress', 'complete', 'cancel'])->nullable();
                $table->string('ms_commission')->nullable();
                $table->tinyInteger('ms_commission_is_percentage')->nullable();
                $table->integer('doctor_total')->nullable();
                $table->integer('ms_total')->nullable();
                $table->integer('grand_total')->nullable();
                $table->timestamp('call_started')->nullable();
                $table->string('call_ended')->nullable();
                $table->tinyInteger('is_doctor_connected')->nullable();
                $table->text('prescription_here')->nullable();
                $table->longText('call_notes')->nullable();
                $table->string('reason_for_visit')->nullable();
                $table->longText('additional_detail')->nullable();
                $table->integer('switch_doctor_count')->nullable();
                $table->longText('switch_reason')->nullable();
                $table->datetime('cancelled_time')->nullable();
                $table->string('confirmation_status')->nullable();
                $table->string('source')->nullable();
                $table->tinyInteger('via_scan')->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->foreign('patient_id')->references('id')->on('patient_info')->onDelete('cascade')->onUpdate('restrict');
                $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('restrict');
            });
        }
        // Add more sample data as needed
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
