<?php

namespace App\Http\Controllers;

use App\Http\Requests\MealsGetRequest;
use App\Language;
use App\Meal;
use DateTime;
use Illuminate\Http\Request;
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

        $diffTimeDateTime = null;
        $tags = null;
        if ($request->has('diff_time')) {
            $diffTimeDateTime = $this->diffTimeToDateTime($request->diff_time);
        }
        if ($request->has('tags')) {
            $tags = $this->tagsToNumberArray($request->tags);
        }


        //$meals = $this->queryGetPaginatedMeals($request, $tags, $diffTimeDateTime);
        DB::connection()->enableQueryLog();
        $meals = Meal::with(
            'translations',
            'category',
            'category.translations',
            'ingredients',
            'ingredients.translations',
            'tags',
            'tags.translations'
        )->filterBy(request()->all());

        if ($request->has('per_page')) {
            $meals = $meals->paginate($request->per_page);
        } else {
            $meals = $meals->paginate(\App\Meal::withTrashed()->max('id'));
        }
        $this->appendRequestDataToLinks($meals);


        $som = new \App\Http\Resources\MealCollection($meals);
        $queries = DB::getQueryLog();
        return $som;
        dd($queries);

        //return new \App\Http\Resources\MealCollection($meals);
    }

    private function setLanguage(string $language)
    {
        App::setLocale($language);
    }

    private function checkLanguageExists(string $language)
    {
        if (!Language::where('lang', $language)->first()) {
            return false;
        }
        return true;
    }


    private function tagsToNumberArray(string $tags)
    {
        return array_map('intval', (explode(',', $tags)));
    }

    private function diffTimeToDateTime(int $diffTime)
    {
        return new DateTime("@$diffTime");
    }


    private function queryGetPaginatedMeals(Request $request, array $tags = null, DateTime $diffTime = null)
    {
        $mealsQuery = \App\Meal::query()->with(
            'translations',
            'category',
            'category.translations',
            'ingredients',
            'ingredients.translations',
            'tags',
            'tags.translations'
        );

        $mealsQuery->when($request->diff_time, function ($query) use ($diffTime) {
            $query->withTrashed();
            $query->where(function ($query) use ($diffTime) {
                $query->where('created_at', '>', $diffTime)
                    ->orWhere('updated_at', '>', $diffTime)
                    ->orWhere('deleted_at', '>', $diffTime);
            });
        }, function ($query) {
            $query->whereColumn('created_at', 'updated_at');
        });

        $mealsQuery->when($tags, function ($query) use ($tags) {
            $query->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('tags.id', $tags);
            }, '=', count($tags));
        });

        $mealsQuery->when(($request->has('category')) && !in_array(strtolower($request->category), ['null', '!null']), function ($query) use ($request) {
            $query->where('category_id', '=', $request->category);
        });

        $mealsQuery->when(strtolower($request->category) === 'null', function ($query) {
            $query->whereNull('category_id');
        });

        $mealsQuery->when(strtolower($request->category) == '!null', function ($query) {
            $query->whereNotNull('category_id');
        });

        if ($request->has('per_page')) {
            $meals = $mealsQuery->paginate($request->per_page);
        } else {
            $meals = $mealsQuery->paginate(\App\Meal::withTrashed()->max('id'));
        }

        return $meals;
    }


    private function appendRequestDataToLinks($meals)
    {
        $meals->appends(request()->input())->links();
    }
}
