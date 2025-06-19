<?php

namespace Merlion\Concerns;

use Illuminate\Support\Str;

trait CanCallMethods
{
    protected function shouldIgnoreMethods(): array
    {
        return $this->except ?? [];
    }

    protected function shouldIgnore($method): bool
    {
        if (Str::startsWith($method, '_')) {
            return true;
        }
        $ignoreMethods = $this->shouldIgnoreMethods();
        return in_array($method, $ignoreMethods ?: []);
    }

    public function callMethods($startWith, $endWith = '', ...$args): void
    {
        $self = static::class;

        $endWith = Str::studly($endWith);
        $methods = array_filter(get_class_methods($self), function ($method) use ($startWith, $endWith) {
            if ($method == $startWith . $endWith) {
                return false;
            }

            if ($this->shouldIgnore($method)) {
                return false;
            }

            return (Str::startsWith($method, $startWith) || empty($startWith)) && (Str::endsWith($method,
                        $endWith) || empty($endWith));
        });

        foreach ($methods as $method) {
            $this->$method(...$args);
        }
    }
}
