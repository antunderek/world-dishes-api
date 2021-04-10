<?php

namespace App\Utilities\MealFilters;

class With
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function handle($value)
    {
        $items = array_map('trim', (explode(',', $value)));
        foreach($items as $item) {
            $this->query->with($item, "{$item}.translations");
        }
    }
}
