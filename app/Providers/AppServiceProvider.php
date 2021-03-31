<?php

namespace App\Providers;

use App\Ingredient;
use App\Meal;
use App\Observers\IngredientObserver;
use App\Observers\MealObserver;
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
    }
}
