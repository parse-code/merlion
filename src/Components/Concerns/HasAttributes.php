<?php

namespace Merlion\Components\Concerns;

use Illuminate\View\ComponentAttributeBag;

trait HasAttributes
{
    public array $sections = [];
    public ?ComponentAttributeBag $attributes;

    const __WRAPPER = 'wrapper';

    public function withAttributes(array $attributes, $section = null): static
    {
        if (empty($section)) {
            $this->attributes = $this->getAttributes()->merge($attributes);
        }

        $this->sections[$section] = $this->getAttributes($section)->merge($attributes);

        return $this;
    }

    public function getAttributes($section = null): ComponentAttributeBag
    {
        if (!empty($section)) {
            $attributes = $this->sections[$section] ?? new ComponentAttributeBag();
        } else {
            if (empty($this->attributes)) {
                $this->attributes = new ComponentAttributeBag();
            }
            $attributes = $this->attributes;
        }

        return $attributes;
    }

    public function buildAttributes(): void
    {
        $this->attributes = $this->getAttributes();

        foreach ($this->attributes as $key => $value) {
            if (is_callable($value)) {
                $this->attributes[$key] = $this->evaluate($value);
            }
        }
    }

    public function class($class, $section = null): static
    {
        if (empty($class)) {
            return $this;
        }
        return $this->withAttributes(['class' => $class], $section);
    }

    public function style($style, $section = null): static
    {
        return $this->withAttributes(['style' => $style], $section);
    }

    public function data($name, $value = '', $section = null): static
    {
        if (is_array($name)) {
            $section = $value;
            foreach ($name as $key => $value) {
                $this->data($key, $value, $section);
            }
            return $this;
        }
        return $this->withAttributes(['data-' . $name => $value], $section);
    }

    public function full(): static
    {
        return $this->class('w-100', 'wrapper');
    }
}
