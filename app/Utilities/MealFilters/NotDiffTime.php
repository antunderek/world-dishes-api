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
        // Only return data with status: 'created'
        $this->query->whereColumn('created_at', 'updated_at');
    }
}
