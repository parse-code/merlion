<?php

namespace Merlion\Components;

use Merlion\Components\Actions\Link;

class InfoList extends Renderable
{
    protected mixed $view = 'merlion::components.infolist';

    const __ITEMS   = 'items';
    const __TOOLS   = 'tools';
    const __ACTIONS = 'actions';

    public function items($info): static
    {
        return $this->components($info, static::__ITEMS);
    }

    public function getItems(): array
    {
        return $this->getComponents(static::__ITEMS);
    }

    public function tools($tools): static
    {
        return $this->components($tools, static::__TOOLS);
    }

    public function getTools(): array
    {
        return $this->getComponents(static::__TOOLS);
    }

    public function actions($actions): static
    {
        return $this->components($actions, static::__ACTIONS);
    }

    public function getActions(): array
    {
        return $this->getComponents(static::__ACTIONS);
    }
}
