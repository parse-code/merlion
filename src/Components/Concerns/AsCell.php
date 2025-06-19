<?php

namespace Merlion\Components\Concerns;

trait AsCell
{
    use HasLabel;

    public function constructCell(...$args): void
    {
        foreach ($args as $key => $arg) {
            if (is_int($key) && is_string($arg)) {
                if ($key === 0) {
                    $this->name($arg);
                }
                if ($key === 1) {
                    $this->label($arg);
                }
            }
        }
    }
}
