<?php

namespace Merlion\Components;

use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Concerns\HasIcon;
use Merlion\Components\Concerns\HasLink;

class Menu extends Renderable
{
    use HasLink;
    use AsCell;
    use HasIcon;

    protected bool $asTitle = false;

    protected mixed $view = 'merlion::components.menu';

    public function asTitle($asTitle = true): static
    {
        $this->asTitle = $asTitle;
        return $this;
    }

    public function isTitle(): bool
    {
        return $this->asTitle;
    }

    public function route($route): static
    {
        $this->link(panel()->route($route));
        return $this;
    }

}
