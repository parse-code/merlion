<?php

namespace Merlion\Components\Concerns\Panel;

use Closure;
use Illuminate\Support\Str;

trait WithRoutes
{
    protected array $routes = [];
    protected string $path;
    protected string $back = '';
    protected array $middleware = [];
    protected string $home = '/';
    protected mixed $pageTitle = null;
    protected mixed $backUrl = null;

    public function path($path): static
    {
        $this->path = $path;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path ?? $this->getId();
    }

    public function back($url): static
    {
        $this->back = $this->url($url);
        return $this;
    }

    public function getBack(): ?string
    {
        return $this->back ?? null;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function getMiddleware(): array
    {
        return [
            'web',
            'panel:' . $this->getId(),
            ...$this->middleware,
        ];
    }

    public function middleware(array $middleware): static
    {
        $this->middleware = [
            ...$this->middleware,
            ...$middleware,
        ];
        return $this;
    }

    public function routes(Closure|string $routes): static
    {
        $this->routes[] = $routes;
        return $this;
    }

    public function route($name, ...$args)
    {
        if (Str::isUrl($name)) {
            return $name;
        }

        if (!Str::startsWith($name, $this->getId() . '.')) {
            $name = $this->getId() . '.' . $name;
        }

        return route('merlion.' . $name, ...$args);
    }

    public function url($path)
    {
        if (Str::isUrl($path)) {
            return $path;
        }
        $path = Str::startsWith('/', $path) ? $path : '/' . $path;
        return url($this->getPath() . $path);
    }

    public function getHomeUrl()
    {
        return $this->url($this->home);
    }

    public function getHome(): string
    {
        return $this->home;
    }

    public function home($home): static
    {
        $this->home = $home;
        return $this;
    }

    public function pageTitle($pageTitle): static
    {
        $this->pageTitle = $pageTitle;
        return $this;
    }

    public function getPageTitle(): string|null
    {
        return $this->evaluate($this->pageTitle);
    }

    public function backUrl($backUrl): static
    {
        $this->backUrl = $backUrl;
        return $this;
    }

    public function getBackUrl(): string|null
    {
        return $this->evaluate($this->backUrl);
    }
}
