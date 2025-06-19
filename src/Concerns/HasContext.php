<?php

namespace Merlion\Concerns;

trait HasContext
{
    protected array $context = [];

    public function set($key, $value = null): static
    {
        if (is_array($key)) {
            $this->context = array_merge($this->context, $key);
            return $this;
        }
        $this->context[$key] = $value;
        return $this;
    }

    public function get($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->context;
        }
        return $this->evaluate($this->context[$key] ?? $default);
    }
}
