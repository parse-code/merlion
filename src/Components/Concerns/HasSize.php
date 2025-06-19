<?php

namespace Merlion\Components\Concerns;

trait HasSize
{
    protected mixed $width = null;
    protected mixed $height = null;

    public function width($width): static
    {
        $this->width = $width;
        return $this;
    }

    public function height($height): static
    {
        $this->height = $height;
        return $this;
    }

    public function size($size): static
    {
        return $this->width($size)->height($size);
    }

    public function getWidth()
    {
        return $this->evaluate($this->width);
    }

    public function getHeight()
    {
        return $this->evaluate($this->height);
    }

}
