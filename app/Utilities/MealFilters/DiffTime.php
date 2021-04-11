<?php

namespace App\Utilities\MealFilters;

use DateTime;

class DiffTime
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
