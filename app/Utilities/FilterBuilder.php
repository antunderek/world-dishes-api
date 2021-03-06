<?php

namespace App\Utilities;

class FilterBuilder
{
    // solution from https://dev.to/stefant123/create-filters-in-laravel-with-oop-best-practices-pm9
    protected $query;
    protected $filters;
    protected $namespace;

    public function __construct($query, $filters, $namespace)
    {
        $this->query = $query;
        $this->filters = $filters;
        $this->namespace = $namespace;
    }

    public function apply()
    {
        foreach ($this->filters as $name => $value) {
            $nam = array_map('ucfirst', explode('_', $name));
            $normalizedName = implode($nam);
            $class = $this->namespace . "\\{$normalizedName}";

            if (!class_exists($class)) {
                continue;
            }

            if (strlen($value)) {
                (new $class($this->query))->handle($value);
            } else {
                (new $class($this->query))->handle();
            }
        }

        return $this->query;
    }
}
