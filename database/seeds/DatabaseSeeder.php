<?php

use App\Category;
use App\Ingredient;
use App\Meal;
use App\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguageSeeder::class);
        factory(Category::class, 5)->create();
        factory(Tag::class, 10)->create();
        factory(Ingredient::class, 10)->create();

        factory(Meal::class, 10)->create()->each(function ($meal) {
            $this->attachTagsIngredients($meal);
        });

        factory(Meal::class, 3)->state('category_null')->create()->each(function ($meal) {
            $this->attachTagsIngredients($meal);
        });

        factory(Meal::class, 5)->state('modified')->create()->each(function ($meal) {
            $this->attachTagsIngredients($meal);
        });

        factory(Meal::class, 5)->state('deleted')->create()->each(function ($meal) {
            $this->attachTagsIngredients($meal);
        });

    }

    private function attachTagsIngredients(Meal $meal) {
        $meal->tags()->attach(Tag::all()->pluck('id')->random(rand(1, 6)));
        $meal->ingredients()->attach(Ingredient::all()->pluck('id')->random(rand(1, 6)));
    }
}
