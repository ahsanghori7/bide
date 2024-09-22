<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patient_info', function (Blueprint $table) {
            $table->unsignedBigInteger('clinic_user_id')->nullable()->after('status');
            $table->foreign('clinic_user_id')->references('id')->on('clinic_user')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_info', function (Blueprint $table) {
            //
        });
    }
};
