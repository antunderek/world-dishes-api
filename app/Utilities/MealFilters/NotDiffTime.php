<?php

namespace App\Utilities\MealFilters;

use App\Utilities\FilterNoParametersInterface;

class NotDiffTime implements FilterNoParametersInterface
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function handle()
    {
        $this->query->whereColumn('created_at', 'updated_at');
    }
}
