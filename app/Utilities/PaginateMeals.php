<?php

namespace App\Utilities;

class PaginateMeals implements PaginateMealsInterface
{
    protected $query;
    protected $request;

    public function __construct($query, $request)
    {
        $this->query = $query;
        $this->request = $request;
    }

    public function paginateMealsIndex()
    {
        if ($this->request->has('per_page')) {
            $meals = $this->query->paginate($this->request->per_page);
        } else {
            $meals = $this->query->paginate(\App\Meal::withTrashed()->max('id'));
        }
        $this->appendRequestDataToLinks($meals);
        return $meals;
    }

    private function appendRequestDataToLinks($meals)
    {
        $meals->appends(request()->input())->links();
    }
}
