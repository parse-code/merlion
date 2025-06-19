<?php

namespace Merlion\Components\Filters;

use Closure;
use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Concerns\HasLabel;
use Merlion\Components\Concerns\HasName;
use Merlion\Components\Renderable;

class Filter extends Renderable
{
    use AsCell;

    protected Closure $applyFilerUsing;

    public function getValue()
    {
        return request($this->getName());
    }

    public function applyFilter($builder)
    {
        if (!empty($this->applyFilerUsing)) {
            return $this->tap($this->applyFilerUsing);
        }

        if (is_null($this->getValue())) {
            return $builder;
        }

        return $builder->where($this->getName(), $this->getValue());
    }
}
