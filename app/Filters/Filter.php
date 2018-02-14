<?php

namespace App\Filters;

use Symfony\Component\HttpFoundation\Request;

abstract class Filter
{
    protected $filters = [];
    protected $request;
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    protected function getFilters()
    {
        return $this->request->only($this->filters);
    }
}
