<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\{
    Category,
    Language
};
use Faker\Factory as Faker;
use Illuminate\Support\Str;

$factory->define(Category::class, function () {
    static $values = [];

    $languages = Language::all();
    $result = [];

    foreach ($languages as $language) {
        $fakerProvider = "FakerRestaurant\Provider\\" . $language->locale . "\Restaurant";
        $faker = Faker::create();
        $faker->addProvider(new $fakerProvider($faker));

        while (true) {
            $val = [
                "title:{$language->lang}" => ($faker->meatName() . $faker->randomNumber()),
                "lang_id:{$language->lang}" => $language->id,
            ];
            if (!in_array($val["title:{$language->lang}"], $values)) {
                $result = array_merge($result, $val);
                array_push($values, $val["title:{$language->lang}"]);
                break;
            }
        }
    }

    $slug = ["slug" => Str::slug($result['title:en'], '-')];
    $result = array_merge($result, $slug);

    return $result;
});
