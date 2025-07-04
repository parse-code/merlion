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

    public function getMenus($position = 'menus'): array
    {
        return $this->fetch($position);
    }
}
