<?php

namespace Merlion\Components\Tabs;

use Merlion\Components\Renderable;

class Tabs extends Renderable
{
    protected mixed $view = 'merlion::components.tabs.tabs';

    public function tab($tabs): static
    {
        $this->components($tabs, 'tabs');
        return $this;
    }

    public function getTabs(): array
    {
        return $this->getComponents('tabs');
    }
}
