<?php

namespace Merlion\Components\Concerns;

trait HasContext
{
    protected array $context = [];

    private array $_stack = [];

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

    public function push($key, $value = null): static
    {
        if (empty($this->_stack[$key])) {
            $this->_stack = [];
        }
        $this->_stack[$key][] = $value;
        return $this;
    }

    public function clear($key = null): static
    {
        if (empty($key)) {
            $this->_stack = [];
            return $this;
        }

        if (!empty($this->_stack[$key])) {
            $this->_stack[$key] = [];
        }

        return $this;
    }

    public function fetch($key): array
    {
        $items  = $this->_stack[$key] ?? [];
        $result = [];
        foreach ($items as $item) {
            if (is_callable($item)) {
                $result[] = $this->evaluate($item);
                continue;
            }
            if (is_array($item)) {
                $result = array_merge($result, $item);
            }
        }
        return $result;
    }
}
