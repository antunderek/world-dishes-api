<?php

namespace App\Utilities\MealFilters;

class Tags
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function handle($value)
    {
        // prep tags value to number array (use separate class?)
        $tags = array_map('intval', (explode(',', $value)));
        $this->query->whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('tags.id', $tags);
        }, '=', count($tags));
    }
}
