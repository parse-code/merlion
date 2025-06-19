<?php

namespace Merlion\Components;

class Inertia extends Renderable
{
    protected mixed $page;
    protected mixed $view = 'merlion::components.layouts.inertia';

    public static string $rootView = 'merlion::components.layouts.inertia';
    public static array $resources = ['resources/js/app.tsx'];
    public static string $buildDirectory = 'build';

    public static function withResources($resources): void
    {
        static::$resources = $resources;
    }

    public static function withBuildDirectory($buildDirectory): void
    {
        static::$buildDirectory = $buildDirectory;
    }

    public function __construct(...$args)
    {
        parent::__construct(...$args);
        if (is_string($args[0] ?? null)) {
            $this->page($args[0]);
        }

        if (is_array($args[1] ?? null)) {
            $this->set($args[1]);
        }
    }

    public function page($page): static
    {
        $this->page = $page;
        return $this;
    }

    public function getPage(): string
    {
        return $this->evaluate($this->page);
    }

    public function render()
    {
        $this->build();
        $this->callMethods('render');
        return \Inertia\Inertia::render($this->getPage(), $this->get())->toResponse(request())->getContent();
    }

    protected function defaultId(): string
    {
        return 'inertia_root';
    }
}
