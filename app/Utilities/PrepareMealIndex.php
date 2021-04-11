<?php

namespace App\Utilities;

use App\Http\Resources\MealCollection;
use App\Meal;
use Illuminate\Support\Facades\App;

class PrepareMealIndex
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function setup()
    {
        App::setLocale($this->request->lang);
        $customFilters = new CustomMealFilters($this->request);
        $meals = Meal::with('translations')->filterBy($customFilters->getFilters());
        $paginator = new PaginateMeals($meals, $this->request);
        $meals = $paginator->paginateMealsIndex();
        return new MealCollection($meals);
    }
}
