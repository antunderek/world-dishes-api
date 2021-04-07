<?php

namespace App\Utilities\MealFilters;

class PerPage
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function handle($value)
    {
        $this->query->paginate($value);
    }
}
