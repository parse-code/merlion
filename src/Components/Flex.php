<?php

namespace Merlion\Components;

class Flex extends Container
{
    public function __construct(...$args)
    {
        if (is_array($args[0] ?? null)) {
            $this->callMethods('register');
            $this->callMethods('construct', '', ...$args);
            $this->components($args[0]);
            $this->callMethods('setup');
        } else {
            parent::__construct(...$args);
        }
    }

    public function setupFlex(): void
    {
        $this->flex()->gap(2)->wrap();
    }

    public function column(): static
    {
        return $this->class('flex-column');
    }
}
