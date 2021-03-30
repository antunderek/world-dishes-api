<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('meal_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            $table->unique(['meal_id', 'tag_id']);

            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meal_tag');
    }
}
