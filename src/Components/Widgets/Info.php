<?php


namespace Merlion\Components\Widgets;


use Merlion\Components\Concerns\HasColor;
use Merlion\Components\Concerns\HasIcon;
use Merlion\Components\Concerns\HasLink;
use Merlion\Components\Renderable;

class Info extends Renderable
{
    use HasLink;
    use HasIcon;
    use HasColor;

    protected mixed $view = 'merlion::components.widgets.info';

    protected mixed $title;
    protected mixed $content;

    public function title($title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->evaluate($this->title);
    }

    public function content($content): static
    {
        $this->content = $content;
        return $this;
    }

    public function getContent(): string
    {
        return $this->evaluate($this->content);
    }
}
