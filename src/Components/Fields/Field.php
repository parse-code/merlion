<?php

namespace Merlion\Components\Fields;

use Closure;
use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Renderable;

class Field extends Renderable
{
    use AsCell;

    protected Closure $saveUsing;

    protected mixed $rules = '';

    public function rules($rules): static
    {
        $this->rules = $rules;
        return $this;
    }

    public function getRules()
    {
        return $this->evaluate($this->rules);
    }

    public function getValueFromRequest()
    {
        return request($this->getName());
    }

    public function saveUsing(Closure $saveUsing): static
    {
        $this->saveUsing = $saveUsing;
        return $this;
    }

    public function processSave($model)
    {
        $this->build();
        if (!empty($this->saveUsing)) {
            return call_user_func($this->saveUsing, $model, $this);
        }
        $model->{$this->getName()} = $this->getValueFromRequest();
        return $model;
    }
}
