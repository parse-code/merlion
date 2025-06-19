<?php

namespace Merlion;

use Closure;

class Crud
{
    protected Closure $getRouteUsing;

    public function __construct(
        public string $model,
        public string $route,
    ) {
    }

    public function getRoute($name, ...$args)
    {
        if (!empty($this->getRouteUsing)) {
            return call_user_func($this->getRouteUsing, $name, ...$args);
        }
        return panel()->route($this->route . '.' . $name, ...$args);
    }
}
