<?php

namespace Merlion\Components;

use Closure;
use Merlion\Components\Concerns\CanBeDefault;
use Merlion\Components\Concerns\Panel\HasAssets;
use Merlion\Components\Concerns\Panel\HasAuth;
use Merlion\Components\Concerns\Panel\HasBrand;
use Merlion\Components\Concerns\Panel\HasLang;
use Merlion\Components\Concerns\Panel\HasMenus;
use Merlion\Components\Concerns\Panel\HasToast;
use Merlion\Components\Concerns\Panel\WithRoutes;

class Panel extends Renderable
{
    use CanBeDefault;
    use WithRoutes;
    use HasAssets;
    use HasAuth;
    use HasBrand;
    use HasLang;
    use HasMenus;
    use HasToast;

    protected mixed $view = 'merlion::components.panel';
    protected array $bootCallbacks = [];

    public function content($content): static
    {
        return $this->components($content, 'content');
    }

    public function getContent(): iterable
    {
        return $this->getComponents('content');
    }

    public function guest(): static
    {
        $this->view('merlion::components.panel_full');
        return $this;
    }

    public function bootUsing(?Closure $callback): static
    {
        $this->bootCallbacks[] = $callback;
        return $this;
    }

    public function boot(): void
    {
        foreach ($this->bootCallbacks as $callback) {
            $callback($this);
        }
    }

}
