<?php

namespace App\Utilities;

use App\Meal;

class FilteredMealsCollection
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function setup()
    {
        $customFilters = new CustomMealFilters($this->request);
        $meals = Meal::with('translations')->filterBy($customFilters->getFilters());
        $paginator = new PaginateMeals($meals, $this->request);
        $meals = $paginator->paginateMealsIndex();
        return new \App\Http\Resources\MealCollection($meals);
    }
}
