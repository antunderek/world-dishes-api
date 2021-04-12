<?php

namespace App\Utilities\MealFilters;

use App\Utilities\FilterInterface;

class Category implements FilterInterface
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function handle($value)
    {
        $this->query->with('category', 'category.translations');

        $this->query->when(!in_array(strtolower($value), ['null', '!null']), function ($query) use ($value) {
            $query->where('category_id', '=', $value);
        });

        $this->query->when(strtolower($value) === 'null', function ($query) {
            $query->whereNull('category_id');
        });

        $this->query->when(strtolower($value) == '!null', function ($query) {
            $query->whereNotNull('category_id');
        });

    }
}
