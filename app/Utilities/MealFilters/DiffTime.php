<?php

namespace App\Utilities\MealFilters;

use App\Utilities\FilterInterface;
use DateTime;

class DiffTime implements FilterInterface
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function handle($value)
    {
        $diffTimeDT = new DateTime("@$value");
        $this->query->withTrashed();
        $this->query->where('created_at', '>', $diffTimeDT);
    }
}
