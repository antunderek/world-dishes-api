<?php

namespace App\Http\Controllers;

use App\Http\Requests\MealsGetRequest;
use App\Meal;
use App\Utilities\CustomMealFilters;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ApiMealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param MealsGetRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(MealsGetRequest $request)
    {
        $this->setLanguage($request->lang);

        DB::connection()->enableQueryLog();
        $customFilters = new CustomMealFilters($request);

        $meals = Meal::with('translations')->filterBy($customFilters->getFilters());

        if ($request->has('per_page')) {
            $meals = $meals->paginate($request->per_page);
        } else {
            $meals = $meals->paginate(\App\Meal::withTrashed()->max('id'));
        }
        $this->appendRequestDataToLinks($meals);


        //DB::connection()->enableQueryLog();
        $som = new \App\Http\Resources\MealCollection($meals);
        $queries = DB::getQueryLog();
        return $som;

        //return new \App\Http\Resources\MealCollection($meals);
    }

    private function setLanguage(string $language)
    {
        App::setLocale($language);
    }

    private function appendRequestDataToLinks($meals)
    {
        $meals->appends(request()->input())->links();
    }
}
