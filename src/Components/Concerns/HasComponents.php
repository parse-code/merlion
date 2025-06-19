<?php

namespace Merlion\Components\Concerns;

use Closure;
use Merlion\Components\Renderable;

trait HasComponents
{
    protected array|Closure|null $components = [];

    public function components($components, $name = null): static
    {
        if (!is_array($components)) {
            $components = [$components];
        }

        if (!empty($name)) {
            if (empty($this->components[$name])) {
                $this->components[$name] = [];
            }
            $this->components[$name] = [
                ...$this->components[$name],
                ...$components,
            ];
        } else {
            $this->components = [
                ...$this->components,
                ...$components,
            ];
        }
        return $this;
    }

    public function getComponents($name = null): array
    {
        if (!empty($name)) {
            $components = $this->components[$name] ?? [];
        } else {
            $components = $this->components ?? [];
        }

        return array_map(function ($child) {
            if (is_callable($child)) {
                $child = evaluate($child, $this);
            }

            if ($child instanceof Renderable) {
                $child->container($this);
            }

            return $child;
        }, $components);
    }
}
