<?php

namespace Merlion\Components\Concerns\Panel;

use Merlion\Components\Menu;

trait HasMenus
{

    protected array $menus = [];

    public function clearMenus(): static
    {
        $this->menus = [];
        return $this;
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
