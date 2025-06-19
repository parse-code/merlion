<?php

namespace Merlion\Components\Filters;

class DateRange extends Filter
{
    protected mixed $view = 'merlion::components.filters.date-range';

    public function applyFilter($builder)
    {
        $from = request($this->getName() . '_from');
        if (!empty($from)) {
            $builder->where($this->getName(), '>=', $from);
        }
        $to = request($this->getName() . '_to');
        if (!empty($to)) {
            $builder->where($this->getName(), '<=', $to);
        }
        return $builder;
    }
}
