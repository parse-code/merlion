<?php

namespace Merlion\Components\Concerns;

trait HasLabel
{
    protected mixed $label = null;

    public function label($label): static
    {
        $this->label = $label;
        return $this;
    }

    public function getLabel(): string|null
    {
        return evaluate($this->label);
    }
}
