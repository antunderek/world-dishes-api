<?php

namespace App\Http\Controllers;

use App\Language;
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
        $this->validateRequest($request);
        $this->setLanguage($request->lang);

        $diffTimeDateTime = null;
        $tags = null;
        if($request->has('diff_time')) {
            $diffTimeDateTime = $this->diffTimeToDateTime($request->diff_time);
        }
        if ($request->has('tags')) {
            $tags = $this->tagsToNumberArray($request->tags);
        }

        $meals = $this->queryGetPaginatedMeals($request, $tags, $diffTimeDateTime);

        $this->appendRequestDataToLinks($meals);

        return new \App\Http\Resources\MealCollection($meals);
    }


    private function validateRequest(Request $request) {
        $request->validate([
            'per_page' => 'integer',
            'tags' => 'regex:/^\d+(,\s*\d+\s*)*$/',
            'lang' => 'required|string|min:2|max:5',
            'with' => 'string',
            'diff_time' => 'integer|regex:/^\s*[1-9]\d*\s*$/',
            'category' => array('regex:/^(\s*|\s*\d+\s*|NULL|!NULL)$/i'),
            'page' => 'integer',
        ]);
    }


    private function setLanguage(string $language) {
        if (!$this->checkLanguageExists($language)) {
            abort(406, 'Language is not supported');
            return;
        }
        App::setLocale($language);
    }

    private function checkLanguageExists(string $language) {
        if (!Language::where('lang', $language)->first()) {
            return false;
        }
        return true;
    }


    private function tagsToNumberArray(string $tags) {
        return array_map('intval', (explode(',', $tags)));
    }

    private function diffTimeToDateTime(int $diffTime) {
        return new DateTime("@$diffTime");
    }


    private function queryGetPaginatedMeals(Request $request, Array $tags=null, DateTime $diffTime=null) {
        $mealsQuery = \App\Meal::query();

        $mealsQuery->when($request->diff_time, function($query) use ($diffTime) {
            $query->withTrashed();
            $query->where(function ($query) use ($diffTime) {
                $query->where('created_at', '>', $diffTime)
                    ->orWhere('updated_at', '>', $diffTime)
                    ->orWhere('deleted_at', '>', $diffTime);
            });
        }, function ($query) {
            $query->whereColumn('created_at', 'updated_at');
        });

        $mealsQuery->when($tags, function($query) use ($tags) {
            $query->whereHas('tags', function($query) use ($tags) {
                $query->whereIn('tags.id', $tags);
            }, '=', count($tags));
        });

        $mealsQuery->when(($request->has('category')) && !in_array(strtolower($request->category), ['null', '!null']), function($query) use ($request) {
            $query->where('category_id', '=', $request->category);
        });

        $mealsQuery->when(strtolower($request->category) === 'null', function($query) {
            $query->whereNull('category_id');
        });

        $mealsQuery->when(strtolower($request->category) == '!null', function($query) {
            $query->whereNotNull('category_id');
        });

        if ($request->has('per_page')) {
            $meals = $mealsQuery->paginate($request->per_page);
        }
        else {
            $meals = $mealsQuery->paginate(\App\Meal::withTrashed()->max('id'));
        }

        return $meals;
    }


    private function appendRequestDataToLinks($meals) {
        $meals->appends(request()->input())->links();
    }
}
