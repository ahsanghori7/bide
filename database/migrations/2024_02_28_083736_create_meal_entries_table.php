<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meal_time_id');
            $table->integer('cereal')->nullable();
            $table->integer('vegetable')->nullable();
            $table->integer('meat')->nullable();
            $table->integer('milk')->nullable();
            $table->integer('fruits')->nullable();
            $table->integer('fats')->nullable();
            $table->integer('calories')->nullable();
            $table->integer('carbo')->nullable();
            $table->integer('protein')->nullable();
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('meal_time_id')->references('id')->on('meal_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meal_entries');
    }
}
