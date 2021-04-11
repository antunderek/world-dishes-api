<?php

namespace App\Observers;

use App\IngredientMeal;

class IngredientMealObserver
{
    /**
     * Handle the ingredient meal "deleting" event.
     *
     * @param \App\IngredientMeal $ingredientMeal
     * @return void
     */
    public function deleted(IngredientMeal $ingredientMeal)
    {
        if ($ingredientMeal->pivotParent->ingredients->count() == 1) {
            $ingredientMeal->pivotParent->forceDelete();
        }
    }
}
