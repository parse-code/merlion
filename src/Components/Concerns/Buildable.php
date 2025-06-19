<?php

namespace Merlion\Components\Concerns;

trait Buildable
{
    protected bool $built = false;
    protected array $buildUsing = [];

    public function building($buildUsing): static
    {
        $this->buildUsing[] = $buildUsing;
        return $this;
    }

    public function build($force = false): void
    {
        if ($this->built && !$force) {
            return;
        }
        $this->callMethods('build');
        foreach ($this->buildUsing as $buildingUsing) {
            call_user_func($buildingUsing, $this);
        }
        $this->built = true;
    }
}
