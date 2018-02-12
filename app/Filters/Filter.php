<?php

namespace App\Filters;

use Symfony\Component\HttpFoundation\Request;

abstract class Filter
{
    protected $filters = [];
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($query)
    {
        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $query = $this->$filter($query);
            }
        }
        return $query;
    }

    protected function getFilters()
    {
        return $this->request->only($this->filters);
    }
}
