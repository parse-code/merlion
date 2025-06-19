<?php

use Illuminate\Contracts\Support\Responsable;
use Merlion\Components\Panel;
use Merlion\MerlionManager;
use Merlion\Models\Setting;

if (!function_exists('evaluate')) {
    function evaluate($value, ...$context)
    {
        if ($value instanceof Closure) {
            return call_user_func($value, ...$context);
        }
        return $value;
    }
}

if (!function_exists('merlion')) {
    function merlion(): MerlionManager
    {
        return app('merlion');
    }
}

if (!function_exists('panel')) {
    function panel($id = null): Panel
    {
        return app('merlion')->panel($id);
    }
}

if (!function_exists('render')) {
    function render($renderable, ...$args)
    {
        if (is_string($renderable)) {
            return $renderable;
        }

        if (is_numeric($renderable)) {
            return (string)$renderable;
        }

        if (is_null($renderable)) {
            return '';
        }

        if (is_bool($renderable)) {
            return $renderable ? 'true' : 'false';
        }

        if (is_array($renderable)) {
            $result = '';
            foreach ($renderable as $item) {
                $result .= render($item, ...$args);
            }

            return $result;
        }


        if ($renderable instanceof Closure) {
            $renderable = evaluate($renderable, ...$args);
            return render($renderable, ...$args);
        }

        if (empty($renderable)) {
            return '';
        }

        if (method_exists($renderable, 'toResponse')) {
            return $renderable;
        }

        if (method_exists($renderable, 'render')) {
            if (is_array($args[0] ?? null) && method_exists($renderable, 'set')) {
                $renderable->set($args[0]);
            }
            return $renderable->render();
        }

        return (string)$renderable;
    }
}

if (!function_exists('to_json')) {
    function to_json($string)
    {
        if ('string' === gettype($string)) {
            return json_decode($string, true);
        }
        return $string;
    }
}
if (!function_exists('to_string')) {
    function to_string($data): string
    {
        if (is_numeric($data)) {
            return (string)$data;
        }
        if (\Illuminate\Support\Str::isJson($data) || is_array($data)) {
            return json_encode($data);
        }
        return (string)$data;
    }
}

if (!function_exists('public_property_exist')) {
    function public_property_exist($object, $propertyName): bool
    {
        if (!property_exists($object, $propertyName)) {
            return false;
        }

        $reflection = new ReflectionProperty($object, $propertyName);
        return $reflection->isPublic();
    }
}

if (!function_exists('public_method_exist')) {
    function public_method_exist($objectOrClass, $methodName): bool
    {
        if (!method_exists($objectOrClass, $methodName)) {
            return false;
        }

        $reflection = new ReflectionMethod($objectOrClass, $methodName);
        return $reflection->isPublic();
    }
}

if (!function_exists('deep_clone')) {
    function deep_clone($objectOrArray)
    {
        if (is_array($objectOrArray)) {
            return array_map(function ($value) {
                return deep_clone($value);
            }, $objectOrArray);
        }
        if (is_object($objectOrArray)) {
            return clone $objectOrArray;
        }
        return $objectOrArray;
    }
}


if (!function_exists('csp_nonce')) {
    function csp_nonce(): string
    {
        return panel()->getNonce();
    }
}

if (!function_exists('setting')) {
    function setting($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                Setting::set($k, $v);
            }
            return null;
        }

        if (empty($value)) {
            return Setting::get($key);
        }

        Setting::set($key, $value);

        return null;
    }
}
