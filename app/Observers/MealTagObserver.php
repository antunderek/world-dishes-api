<?php

namespace App\Observers;

use App\MealTag;

class MealTagObserver
{
    /**
     * Handle the meal tag "deleting" event.
     *
     * @param \App\MealTag $mealTag
     * @return void
     */
    public function deleted(MealTag $mealTag)
    {
        if ($mealTag->pivotParent->tags->count() == 1) {
            $mealTag->pivotParent->forceDelete();
        }
    }
}
