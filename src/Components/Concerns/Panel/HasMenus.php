<?php

namespace Merlion\Components\Concerns\Panel;

trait HasMenus
{

    const MENU_MAIN     = 'menus';
    const MENU_TOP_USER = 'menus_top_user';

    public function clearMenus($position = 'menus'): static
    {
        return $this->clear($position);
    }

    public function menus($menus, $position = 'menus'): static
    {
        $this->push($position, $menus);
        return $this;
    }

    public function userMenus($menus): static
    {
        $this->push(static::MENU_TOP_USER, $menus);
        return $this;
    }

    public function getUserMenus(): array
    {
        $menus      = $this->fetch(static::MENU_TOP_USER);
        $user_menus = [];
        foreach ($menus as $menu) {
            if (is_array($menu)) {
                $user_menus = [...$user_menus, ...$menu];
            } else {
                $user_menus[] = $menu;
            }
        }
        return $user_menus;
    }

    public function getMenus($position = 'menus'): array
    {
        return $this->fetch($position);
    }
}
