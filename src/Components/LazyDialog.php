<?php

namespace Merlion\Components;

use Merlion\Contracts\LazyRenderable;

class LazyDialog extends Renderable
{
    protected mixed $view = 'merlion::components.lazy_dialog';
    protected mixed $content;
    protected mixed $title;

    public function title($title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->title ?? null;
    }

    public function content($content): static
    {
        $this->content = $content;
        return $this;
    }

    public function button($button): static
    {
        $this->components($button, 'button');
        return $this;
    }

    public function getButton(): array
    {
        return $this->getComponents('button');
    }

    public function getContent(): LazyRenderable
    {
        return $this->evaluate($this->content);
    }

    public function getContentUrl(): string
    {
        return $this->getContent()->getUrl();
    }
}
