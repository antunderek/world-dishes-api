<?php

namespace App\Utilities;

class CustomMealFilters
{
    protected $requestArray;

    public function __construct($request)
    {
        $this->requestArray = $request->all();
    }

    public function getFilters()
    {
        return $this->filterNotDiffTime($this->requestArray);
    }

    private function filterNotDiffTime($value)
    {
        if (!array_key_exists('diff_time', $value)) {
            return array_merge($value, ['NotDiffTime' => null]);
        }
        return $value;
    }
}
