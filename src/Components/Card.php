<?php

namespace Merlion\Components;

use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Concerns\HasIcon;
use Merlion\Components\Concerns\HasLink;

class Card extends Container
{
    protected mixed $view = 'merlion::components.card';

    const __HEADER = 'header';
    const __BODY   = 'body';
    const __FOOTER = 'footer';

    public function body($body): static
    {
        return $this->components($body, static::__BODY);
    }

    public function getBody(): array
    {
        return $this->getComponents(static::__BODY);
    }

    public function header($header): static
    {
        return $this->components($header, static::__HEADER);
    }

    public function getHeader(): array
    {
        return $this->getComponents(static::__HEADER);
    }

    public function footer($footer): static
    {
        return $this->components($footer, static::__FOOTER);
    }

    public function getFooter(): array
    {
        return $this->getComponents(static::__FOOTER);
    }
}
