<?php

namespace Merlion\Components\Concerns;

trait Copyable
{
    protected mixed $copyable = false;

    public function copyable($copyable = true): static
    {
        $this->copyable = $copyable;
        return $this;
    }

    public function isCopyable(): bool
    {
        return $this->evaluate($this->copyable);
    }
}
