<?php

namespace Merlion\Components;

class Css extends Renderable
{
    protected mixed $view = 'merlion::components.css';

    public function href($url): static
    {
        $this->withAttributes(['href' => $url]);
        return $this;
    }
}
