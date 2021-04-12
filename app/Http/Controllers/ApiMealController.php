<?php

namespace App\Http\Controllers;

use App\Http\Requests\MealsGetRequest;
use App\Utilities\PrepareMealIndex;

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
        $meals = new PrepareMealIndex($request);
        return response($meals->setup())->setStatusCode(200);
    }
}
