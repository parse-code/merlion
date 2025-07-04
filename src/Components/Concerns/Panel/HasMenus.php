<?php

namespace Merlion\Components\Concerns\Panel;

trait HasMenus
{

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
