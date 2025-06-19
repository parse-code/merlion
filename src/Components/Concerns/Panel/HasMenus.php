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
        $this->menus[] = $menus;
        return $this;
    }

    public function getMenus(): array
    {
        $menus          = $this->menus;
        $compiled_menus = [];
        foreach ($menus as $menu) {
            if (is_array($menu)) {
                $compiled_menus = [
                    ...$compiled_menus,
                    ...$menu,
                ];
                continue;
            }
            if (is_callable($menu)) {
                $compiled_menus[] = $this->evaluate($menu);
                continue;
            }
            if ($menu instanceof Menu) {
                $compiled_menus[] = $menu;
            }
        }
        return $compiled_menus;
    }
}
