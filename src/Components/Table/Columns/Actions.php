<?php

namespace Merlion\Components\Table\Columns;

use Merlion\Components\Actions\Link;

class Actions extends Column
{
    protected mixed $view = 'merlion::components.table.columns.actions';
    protected mixed $max = 0;

    public function max($max): static
    {
        $this->max = $max;
        return $this;
    }

    public function getMax()
    {
        return $this->evaluate($this->max);
    }

    public function link(...$args): static
    {
        $link = Link::make(...$args);
        $this->components($link);
        return $this;
    }
}
