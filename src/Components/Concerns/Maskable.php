<?php

namespace Merlion\Components\Concerns;

use Illuminate\Support\Str;

trait Maskable
{
    protected mixed $mask;

    public function mask($mask = [6, -4]): static
    {
        $this->mask = $mask;
        return $this;
    }

    public function buildingMaskable(): void
    {
        if (!empty($this->mask)) {
            $mask = $this->mask;
            $this->addFilter('get_value', function ($result) use ($mask) {
                return Str::substr($result, 0, $mask[0]) . '****' . Str::substr($result, $mask[1]);
            });
        }
    }
}
