<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ApiMealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        App::setLocale('en');

        $diffTimeDt = null;
        $tags = null;
        if($request->diff_time) {
            $diffTime = $request->diff_time;
            $diffTimeDt = new DateTime("@$diffTime");
        }
        if ($request->has('tags')) {
            $tags = array_map('intval', (explode(',', $request->tags)));
        }

        $mealsQuery = \App\Meal::query();

        $mealsQuery->when($request->diff_time, function($query) use ($diffTimeDt) {
            $query->withTrashed();
            $query->where(function ($query) use ($diffTimeDt) {
                $query->where('created_at', '>', $diffTimeDt)
                    ->orWhere('updated_at', '>', $diffTimeDt)
                    ->orWhere('deleted_at', '>', $diffTimeDt);
            });
        }, function ($query) {
            $query->whereColumn('created_at', 'updated_at');
        });

        $mealsQuery->when($tags, function($query) use ($tags) {
            $query->whereHas('tags', function($query) use ($tags) {
                $query->whereIn('tags.id', $tags);
            }, '=', count($tags));
        });

        $mealsQuery->when(($request->category !== 'null') && ($request->category !== '!null') && ($request->has('category')), function($query) use ($request) {
            $query->where('category_id', '=', $request->category);
        });

        $mealsQuery->when($request->category === 'null', function($query) {
            $query->whereNull('category_id');
        });

        $mealsQuery->when($request->category == '!null', function($query) {
            $query->whereNotNull('category_id');
        });

        if ($request->has('per_page')) {
            $meals = $mealsQuery->paginate($request->per_page);
        }
        else {
            $meals = $mealsQuery->paginate(\App\Meal::withTrashed()->max('id'));
        }

        $meals->appends(request()->input())->links();
        return new \App\Http\Resources\MealCollection($meals);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
