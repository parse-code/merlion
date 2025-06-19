<?php

namespace Merlion\Components\Concerns;

trait CanHidden
{
    protected mixed $hidden = false;

    public function hidden(mixed $hidden): static
    {
        $this->hidden = $hidden;
        return $this;
    }

    protected function isHidden(): bool
    {
        return $this->evaluate($this->hidden);
    }
}
