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

    private function filterNotDiffTime($requestArray)
    {
        if (!array_key_exists('diff_time', $requestArray)) {
            return array_merge($requestArray, ['NotDiffTime' => null]);
        }
        return $requestArray;
    }
}
