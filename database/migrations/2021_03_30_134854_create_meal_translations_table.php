<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('meal_id');
            $table->unsignedBigInteger('lang_id');
            $table->string('name');
            $table->string('description');
            $table->string('locale')->index();
            $table->timestamps();

            $table->unique(['meal_id', 'lang_id', 'locale']);

            $table->foreign('lang_id')->references('id')->on('languages')->onDelete('cascade');
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meal_translations');
    }
}
