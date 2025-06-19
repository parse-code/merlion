<?php

namespace Merlion\Components\Concerns;

use Merlion\Components\Renderable;

trait BelongsToContainer
{
    protected Renderable $container;

    public function container(Renderable $container): static
    {
        $this->container = $container;
        return $this;
    }

    public function getContainer(): ?Renderable
    {
        return $this->container ?? null;
    }

}
