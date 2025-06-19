<?php

namespace Merlion\Components\Concerns;

trait HasIcon
{
    protected mixed $icon = null;
    protected bool $position_start = true;

    public function icon($icon, $position_start = true): static
    {
        $this->icon           = $icon;
        $this->position_start = $position_start;
        return $this;
    }

    public function getIcon(): string|null
    {
        return $this->evaluate($this->icon);
    }

    public function isIconStart(): bool
    {
        return $this->position_start;
    }

}
