<?php

namespace Merlion\Components\Actions;

use Merlion\Components\Concerns\HasIcon;
use Merlion\Components\Concerns\HasLink;

class Link extends Action
{
    use HasLink;
    use HasIcon;

    protected mixed $view = 'merlion::components.actions.link';
}
