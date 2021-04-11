<?php

namespace App\Observers;

use App\Meal;

class MealObserver
{
    /**
     * Handle the meal "updated" event.
     *
     * @param \App\Meal $meal
     * @return void
     */
    public function updated(Meal $meal)
    {
        if ($meal->tags->count() == 0 || $meal->ingredients()->count == 0) {
            $meal->forceDelete();
        } else if ($meal->trashed()) {
            $meal->restore();
        }
    }

    /**
     * Handle the meal "restored" event.
     *
     * @param \App\Meal $meal
     * @return void
     */
    public function restored(Meal $meal)
    {
        if ($meal->tags->count() == 0 || $meal->ingredients()->count == 0) {
            $meal->forceDelete();
        }
    }
}
