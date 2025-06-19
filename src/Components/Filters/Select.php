<?php

namespace Merlion\Components\Filters;

class Select extends Filter
{
    protected mixed $view = 'merlion::components.filters.select';
    protected mixed $options;

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
