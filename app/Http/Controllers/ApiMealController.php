<?php

namespace App\Http\Controllers;

use App\Http\Requests\MealsGetRequest;
use App\Utilities\FilteredMealsCollection;
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

        $meals = new FilteredMealsCollection($request);
        return $meals->setup();

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
}
