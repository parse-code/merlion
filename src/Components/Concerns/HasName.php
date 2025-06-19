<?php

namespace Merlion\Components\Concerns;

trait HasName
{
    protected mixed $name = null;

    public function name($name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->evaluate($this->name ?? $this->getDefaultName());
    }

    protected function getDefaultName(): string
    {
        $this->name = class_basename(static::class) . '_' . uniqid();
        return $this->name;
    }
}
