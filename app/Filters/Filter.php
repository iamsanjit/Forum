<?php

namespace App\Filters;

use Symfony\Component\HttpFoundation\Request;

abstract class Filter
{
    protected $filters = [];
    protected $request;
    protected $query;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($query)
    {
        $this->query = $query;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->query;
    }

    protected function getFilters()
    {
        return $this->request->only($this->filters);
    }
}
