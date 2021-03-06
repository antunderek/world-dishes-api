<?php

namespace App\Utilities\MealFilters;

use App\Utilities\FilterInterface;

class Tags implements FilterInterface
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function handle($value)
    {
        $this->query->with('tags', 'tags.translations');
        $tags = array_map('intval', (explode(',', $value)));
        $this->query->whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('tags.id', $tags);
        }, '=', count($tags));
    }
}
