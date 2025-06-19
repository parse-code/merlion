<?php

namespace Merlion\Components\Concerns\Panel;

use Illuminate\Support\Facades\Log;

trait HasMenus
{

    public function clearMenus(): static
    {
        return $this->clear('menus');
    }

    public function menus($menus): static
    {
        $this->push('menus', $menus);
        return $this;
    }

    public function getMenus(): array
    {
        return $this->fetch('menus');
    }
}
