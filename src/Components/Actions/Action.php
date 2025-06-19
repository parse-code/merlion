<?php

namespace Merlion\Components\Actions;

use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Concerns\HasIcon;
use Merlion\Components\Renderable;
use staabm\SideEffectsDetector\SideEffect;

class Action extends Renderable
{
    use AsCell;
    use HasIcon;

    protected mixed $view = 'merlion::components.actions.button';

    public function color($type): static
    {
        return $this->class('btn btn-' . $type);
    }

    public function post($action): static
    {
        $this->data('action', $action)
            ->data('method', 'post');

        return $this;
    }

    public function size($size): static
    {
        return $this->class('btn-' . $size);
    }
}
