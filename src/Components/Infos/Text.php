<?php

namespace Merlion\Components\Infos;

use Merlion\Components\Concerns\Copyable;
use Merlion\Components\Concerns\HasLink;
use Merlion\Components\Concerns\Maskable;

class Text extends Info
{
    use Copyable;
    use Maskable;
    use HasLink;

    protected mixed $view = 'merlion::components.infos.text';

    public function badge($color = 'primary'): static
    {
        return $this->class('badge text-bg-' . $color);
    }
}
