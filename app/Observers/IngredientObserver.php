<?php

namespace App\Observers;

use App\Ingredient;

class IngredientObserver
{
    /**
     * Handle the ingredient "deleting" event.
     *
     * @param \App\Ingredient $ingredient
     * @return void
     */
    public function deleting(Ingredient $ingredient)
    {
        foreach ($ingredient->meals as $meal) {
            if ($meal->tags->count() == 1) {
                $meal->forceDelete();
            }
        }
    }
}
