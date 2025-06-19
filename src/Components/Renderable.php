<?php

namespace Merlion\Components;

use Closure;
use Illuminate\Contracts\Support\Renderable as RenderableContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\InvokableComponentVariable;
use Merlion\Components\Concerns\BelongsToContainer;
use Merlion\Components\Concerns\BelongsToModal;
use Merlion\Components\Concerns\Buildable;
use Merlion\Components\Concerns\CanHidden;
use Merlion\Components\Concerns\HasAttributes;
use Merlion\Components\Concerns\HasComponents;
use Merlion\Components\Concerns\HasContext;
use Merlion\Components\Concerns\HasHooks;
use Merlion\Components\Concerns\HasId;
use Merlion\Components\Concerns\HasName;
use Merlion\Concerns\CanCallMethods;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

class Renderable implements RenderableContract
{
    use CanCallMethods;
    use CanHidden;
    use BelongsToContainer;
    use BelongsToModal;
    use Buildable;
    use HasAttributes;
    use HasComponents;
    use HasContext;
    use HasHooks;
    use HasId;
    use HasName;
    use Macroable;

    protected array $except = [
        'boot',
        'build',
        'building',
        'components',
        'container',
        'display',
        'flushMacros',
        'get',
        'hasMacro',
        'ignoredParameterNames',
        'macro',
        'make',
        'mixin',
        'register',
        'render',
        'set',
        'setup',
        'toJsonResponse',
        'toResponse',
        'withView',
    ];

    protected mixed $display;
    protected mixed $view = 'merlion::components.renderable';

    protected static array $propertyCache = [];

    protected static array $methodCache = [];

    public static function make(...$arguments): static
    {
        return new static(...$arguments);
    }

    public function __construct(...$args)
    {
        $this->callMethods('register');
        $this->callMethods('construct', '', ...$args);
        foreach ($args as $key => $arg) {
            if (is_string($key)) {
                if (public_method_exist($this, $key)) {
                    $this->$key($arg);
                    continue;
                }
                if (public_property_exist($this, $key)) {
                    $this->{$key} = $arg;
                    continue;
                }
            }

            if (is_int($key) && is_array($arg)) {
                foreach ($arg as $_key => $_value) {
                    if (public_method_exist($this, $_key)) {
                        $this->$_key($_value);
                        continue;
                    }
                    if (public_property_exist($this, $key)) {
                        $this->{$_key} = $_value;
                    }
                }
                break;
            }

            if (is_int($key) && ($arg instanceof Closure)) {
                call_user_func($arg, $this);
            }
        }
        $this->callMethods('setup');
    }

    public function view($view): static
    {
        $this->view = $view;
        return $this;
    }

    public function display($display): static
    {
        $this->display = $display;
        return $this;
    }

    public function render()
    {
        $this->build();

        if ($this->isHidden()) {
            return '';
        }

        if (!empty($this->display)) {
            return $this->evaluate($this->display);
        }

        $this->callMethods('render');

        return view($this->evaluate($this->view), $this->getData());
    }

    protected function getData(): array
    {
        $this->attributes = $this->attributes ?? $this->newAttributeBag();

        $data = array_merge($this->extractPublicProperties(), $this->extractPublicMethods());

        return array_merge($data, $this->context);
    }

    protected function extractPublicProperties(): array
    {
        $class = get_class($this);

        if (!isset(static::$propertyCache[$class])) {
            $reflection = new ReflectionClass($this);

            static::$propertyCache[$class] = (new Collection($reflection->getProperties(ReflectionProperty::IS_PUBLIC)))
                ->reject(fn(ReflectionProperty $property) => $property->isStatic())
                ->reject(fn(ReflectionProperty $property) => $this->shouldIgnore($property->getName()))
                ->map(fn(ReflectionProperty $property) => $property->getName())
                ->all();
        }

        $values = [];

        foreach (static::$propertyCache[$class] as $property) {
            $values[$property] = $this->{$property};
        }

        return $values;
    }

    protected function extractPublicMethods(): array
    {
        $class = get_class($this);

        if (!isset(static::$methodCache[$class])) {
            $reflection = new ReflectionClass($this);

            static::$methodCache[$class] = (new Collection($reflection->getMethods(ReflectionMethod::IS_PUBLIC)))
                ->reject(fn(ReflectionMethod $method) => $this->shouldIgnore($method->getName()))
                ->map(fn(ReflectionMethod $method) => $method->getName());
        }

        $values = [];

        foreach (static::$methodCache[$class] as $method) {
            $values[$method] = $this->createVariableFromMethod(new ReflectionMethod($this, $method));
        }

        return $values;
    }

    protected function createVariableFromMethod(ReflectionMethod $method): InvokableComponentVariable|Closure
    {
        return $method->getNumberOfParameters() === 0
            ? $this->createInvokableVariable($method->getName())
            : Closure::fromCallable([$this, $method->getName()]);
    }

    protected function createInvokableVariable(string $method): InvokableComponentVariable
    {
        return new InvokableComponentVariable(function () use ($method) {
            return $this->{$method}();
        });
    }

    protected function newAttributeBag(array $attributes = []): ComponentAttributeBag
    {
        return new ComponentAttributeBag($attributes);
    }

    protected function tap($callback)
    {
        return call_user_func($callback, $this);
    }

    protected function evaluate($callback, ...$params)
    {
        if (empty($params)) {
            $params = [$this];
        }
        return evaluate($callback, ...$params);
    }
}
