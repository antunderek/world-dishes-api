<?php

use App\{
    Category,
    Ingredient,
    Meal,
    Tag
};
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
        factory(Category::class, 15)->create();
        factory(Tag::class, 30)->create();
        factory(Ingredient::class, 30)->create();

        factory(Meal::class, 100)->create()->each(function ($meal) {
            $this->attachTagsIngredients($meal);
        });

        factory(Meal::class, 13)->state('category_null')->create()->each(function ($meal) {
            $this->attachTagsIngredients($meal);
        });

        factory(Meal::class, 25)->state('modified')->create()->each(function ($meal) {
            $this->attachTagsIngredients($meal);
        });

        factory(Meal::class, 15)->state('deleted')->create()->each(function ($meal) {
            $this->attachTagsIngredients($meal);
        });

    }

    private function attachTagsIngredients(Meal $meal)
    {
        $meal->tags()->attach(Tag::all()->pluck('id')->random(rand(1, 10)));
        $meal->ingredients()->attach(Ingredient::all()->pluck('id')->random(rand(1, 10)));
    }
}
