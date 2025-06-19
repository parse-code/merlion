<?php

namespace Merlion\Components\Concerns;

use Merlion\Components\Table\Table;

trait BelongsToTable
{
    public function getTable($parent = null): ?Table
    {
        if (empty($parent)) {
            $parent = $this;
        }

        $container = $parent->getContainer();

        if (empty($container)) {
            return null;
        }

        if ($container instanceof Table) {
            return $container;
        }

        return $this->getTable($container);
    }

}
