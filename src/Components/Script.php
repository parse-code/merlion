<?php

namespace Merlion\Components;

class Script extends Renderable
{
    protected mixed $view = 'merlion::components.script';
    protected string $src;
    protected mixed $script;

    public function src($src): static
    {
        $this->withAttributes(['src' => $src]);
        return $this;
    }

    public function script($script): static
    {
        $this->script = $script;
        return $this;
    }

    public function async(): static
    {
        $this->withAttributes(['async' => '']);
        return $this;
    }

    public function defer(): static
    {
        $this->withAttributes(['defer' => '']);
        return $this;
    }

    public function getScript()
    {
        return $this->evaluate($this->script ?? null);
    }
}
