<?php

namespace Merlion\Components\Fields;

class Editor extends Field
{
    protected mixed $view = 'merlion::components.fields.editor';
    protected mixed $options = [];
    protected mixed $rich = true;

    public function rich($rich): static
    {
        $this->rich = $rich;
        return $this;
    }

    public function isRich(): bool
    {
        return $this->rich;
    }

    public function setupEditor(): void
    {
        $this->class('h-100', 'wrapper');
    }

    public function options($options): static
    {
        $this->options = $options;
        return $this;
    }

    public function getOptions()
    {
        return $this->evaluate($this->options);
    }
}
