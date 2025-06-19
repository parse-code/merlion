<?php

namespace Merlion\Components\Table\Columns;

use Closure;
use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Renderable;

class Column extends Renderable
{
    use AsCell;

    protected Closure $applySortUsing;
    protected mixed $sortable = false;

    public function getHeader()
    {
        return Header::make()->container($this);
    }

    public function sortable($sortable = true): static
    {
        $this->sortable = $sortable;
        return $this;
    }

    public function isSortable()
    {
        return $this->sortable;
    }

    public function applySort($builder)
    {
        if (!empty($this->applySortUsing)) {
            return $this->tap($this->applySortUsing);
        }
        return $builder->orderBy($this->getName(), request('sort_type', 'asc'));
    }
}
