<?php

namespace Merlion;

use Illuminate\Support\Arr;
use Merlion\Components\Panel;
use Merlion\Exceptions\NoDefaultPanelSetException;

class MerlionManager
{
    protected Panel $currentPanel;

    protected array $panels = [];

    protected bool $currentPanelBooted = false;

    public function register(Panel $panel): static
    {
        $this->panels[$panel->getId()] = $panel;
        return $this;
    }

    public function panels(): array
    {
        return $this->panels;
    }

    public function setCurrentPanel($panel): static
    {
        $this->currentPanel = $panel;
        return $this;
    }

    public function bootCurrentPanel(): void
    {
        if ($this->currentPanelBooted) {
            return;
        }

        $this->currentPanel->boot();
        $this->currentPanelBooted = true;
    }

    public function getCurrentPanel()
    {
        return $this->currentPanel ?? $this->defaultPanel();
    }

    public function panel($id = null)
    {
        if (empty($id)) {
            return $this->getCurrentPanel();
        }
        return $this->find($id);
    }

    protected function defaultPanel()
    {
        return Arr::first(
            $this->panels,
            fn(Panel $panel): bool => $panel->isDefault(),
            fn() => throw NoDefaultPanelSetException::make(),
        );
    }

    protected function find($id)
    {
        return $this->panels[$id] ?? null;
    }

}
