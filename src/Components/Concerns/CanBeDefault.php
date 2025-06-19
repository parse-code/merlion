<?php

namespace Merlion\Components\Concerns;

trait CanBeDefault
{
    protected bool $default = false;

    public function default(bool $default = true): static
    {
        $this->default = $default;
        return $this;
    }

    public function isDefault(): bool
    {
        return $this->default;
    }
}
