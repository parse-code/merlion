<?php

namespace Merlion\Components\Concerns;

trait HasLink
{
    protected mixed $link = null;
    protected mixed $target = '_self';

    public function link($link, $target = null): static
    {
        $this->link = $link;
        if (!empty($target)) {
            $this->target($target);
        }
        return $this;
    }

    public function target($target): static
    {
        $this->target = $target;
        return $this;
    }

    public function blank(): static
    {
        $this->target('blank');
        return $this;
    }

    public function getLink(): string|null
    {
        return $this->evaluate($this->link);
    }

    public function getTarget(): string
    {
        return $this->evaluate($this->target);
    }

}
