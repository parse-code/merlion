<?php

namespace Merlion\Components\Table\Columns;

use Merlion\Components\Concerns\HasSize;

class Image extends Column
{
    use HasSize;

    protected mixed $view = 'merlion::components.table.columns.image';

    public function rounded(): static
    {
        return $this->class("rounded");
    }
}
