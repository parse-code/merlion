<?php

namespace Merlion\Components\Tabs;

use Merlion\Components\Concerns\HasLabel;
use Merlion\Components\Concerns\HasLink;
use Merlion\Components\Container;

class Tab extends Container
{
    use HasLabel;
    use HasLink;

    public function render()
    {
        if ($this->getLink()) {
            return null;
        }

        return parent::render();
    }
}
