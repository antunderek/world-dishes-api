<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\{
    Language,
    Meal,
    Category
};
use Carbon\Carbon;
use Faker\Factory as Faker;

$factory->define(Meal::class, function () {
    $languages = Language::all();
    $result = [];

    foreach ($languages as $language) {
        $fakerProvider = "FakerRestaurant\Provider\\" . $language->locale . "\Restaurant";
        $faker = Faker::create();
        $faker->addProvider(new $fakerProvider($faker));

        $val = [
            "name:{$language->lang}" => $faker->foodName(),
            "description:{$language->lang}" => $faker->beverageName(),
            "lang_id:{$language->lang}" => $language->id,
        ];
        $result = array_merge($result, $val);
    }

    $category = ['category_id' => Category::all()->pluck('id')->random()];
    $result = array_merge($result, $category);

    return $result;
});

$factory->state(Meal::class, 'deleted', ['deleted_at' => Carbon::now()]);

$factory->state(Meal::class, 'modified', ['updated_at' => Carbon::now()->addDay()]);

$factory->state(Meal::class, 'category_null', ['category_id' => null]);
