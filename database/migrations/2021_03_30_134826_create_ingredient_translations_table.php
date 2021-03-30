<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredient_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ingredient_id');
            $table->unsignedBigInteger('lang_id');
            $table->string('title');
            $table->string('locale')->index();
            $table->timestamps();

            $table->unique(['ingredient_id', 'lang_id', 'locale']);

            $table->foreign('lang_id')->references('id')->on('languages')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredient_translations');
    }
}
