<?php

namespace Merlion\Components\Concerns;

use Merlion\Support\Hooks;

trait HasHooks
{
    protected Hooks $hooks;

    public function getHooks(): Hooks
    {
        if (empty($this->hooks)) {
            $this->hooks = new Hooks();
        }
        return $this->hooks;
    }

    protected function getHookCallback($callback): callable|array
    {
        if (is_string($callback) && strpos($callback, '@')) {
            $callback = explode('@', $callback);
            return [app('\\' . $callback[0]), $callback[1]];
        }

        if (is_string($callback)) {
            return [app('\\' . $callback), 'handle'];
        }

        return $callback;
    }

    public function addAction($name, $callback, $priority = 10, $accepted_args = 1): static
    {
        $this->getHooks()->add_action($name, $this->getHookCallback($callback), $priority, $accepted_args);
        return $this;
    }

    public function doActions($name, $args = null): static
    {
        $this->getHooks()->do_action($name, $args);
        return $this;
    }

    public function addFilter($name, $callback, $priority = 10, $accepted_args = 1): static
    {
        $this->getHooks()->add_filter($name, $this->getHookCallback($callback), $priority, $accepted_args);
        return $this;
    }

    public function doFilters($name, $value = null): mixed
    {
        return $this->getHooks()->apply_filters($name, $value);
    }
}
