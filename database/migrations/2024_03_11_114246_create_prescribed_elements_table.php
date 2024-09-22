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
        Schema::create('prescribed_elements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prescription_id');
            $table->unsignedBigInteger('prescription_element_id');
            $table->enum('type', ['medicine', 'lab', 'insulin']);
            $table->unsignedBigInteger('generic_id')->nullable(true);
            $table->unsignedBigInteger('type_id')->nullable(true);
            $table->unsignedBigInteger('route_id')->nullable(true);
            $table->unsignedBigInteger('item_strength_id')->nullable(true);
            $table->string('unit')->nullable(true);
            $table->string('number_of_days')->nullable();
            $table->boolean('is_after_meal')->nullable();
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
        Schema::dropIfExists('prescribed_elements');
    }
};
