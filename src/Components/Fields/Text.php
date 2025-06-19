<?php

namespace Merlion\Components\Fields;

class Text extends Field
{
    protected mixed $view = 'merlion::components.fields.text';
    protected string $type = 'text';

    public function type($type): static
    {
        $this->type = $type;
        return $this;
    }

    public function password(): static
    {
        return $this->type('password');
    }

    public function getType(): string
    {
        return $this->type;
    }
}
