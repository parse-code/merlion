<?php

namespace Merlion\Components;

class Container extends Renderable
{
    protected mixed $view = 'merlion::components.container';

    public function wrap(): static
    {
        return $this->class('flex-wrap');
    }

    public function flex($column = false): static
    {
        $this->class('d-flex');
        if ($column) {
            $this->class('flex-column');
        }
        return $this;
    }

    public function row($itemClass = null): static
    {
        $this->class('row');
        $this->class($itemClass, 'items');
        return $this;
    }

    public function gap($gap = 3): static
    {
        return $this->class('gap-' . $gap);
    }

    public function justify($justify = 'center'): static
    {
        return $this->class('justify-content-' . $justify);
    }

    public function align($align = 'center'): static
    {
        return $this->class('align-items-' . $align);
    }
}
