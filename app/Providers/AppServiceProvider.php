<?php

namespace App\Providers;

use App\Ingredient;
use App\IngredientMeal;
use App\Meal;
use App\MealTag;
use App\Observers\IngredientMealObserver;
use App\Observers\IngredientObserver;
use App\Observers\MealObserver;
use App\Observers\MealTagObserver;
use App\Observers\TagObserver;
use App\Tag;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Meal::observe(MealObserver::class);
        Tag::observe(TagObserver::class);
        Ingredient::observe(IngredientObserver::class);
        MealTag::observe(MealTagObserver::class);
        IngredientMeal::observe(IngredientMealObserver::class);
    }
}
