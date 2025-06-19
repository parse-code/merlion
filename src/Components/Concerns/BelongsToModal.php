<?php

namespace Merlion\Components\Concerns;

trait BelongsToModal
{
    protected mixed $model;
    protected string $model_route = '';
    protected mixed $getValueUsing;

    public function model($model): static
    {
        $this->model = $model;
        return $this;
    }

    public function value($getValueUsing): static
    {
        $this->getValueUsing = $getValueUsing;
        return $this;
    }

    public function getModel()
    {
        if (!empty($this->get('model'))) {
            return $this->get('model');
        }

        if (!empty($this->model)) {
            return $this->model;
        }

        return $this->getContainer()?->getModel() ?? null;
    }

    public function getModelKey()
    {
        $model = $this->getModel();

        if (empty($model) || !is_object($model)) {
            return null;
        }

        if (method_exists($model, 'getKey')) {
            return $model->getKey();
        }
        return data_get($model, 'id') ?? null;
    }

    public function getValueUsing($getValueUsing): static
    {
        $this->getValueUsing = $getValueUsing;
        return $this;
    }

    public function getValue()
    {
        if (!empty($this->getValueUsing)) {
            $value = $this->evaluate($this->getValueUsing);
        } else {
            $value = data_get($this->getModel(), $this->getName());
        }

        return $this->doFilters('get_value', $value);
    }

    public function modelRoute($route): static
    {
        $this->model_route = $route;
        return $this;
    }

    public function getModelRoute($name, ...$args): string
    {
        if (empty($this->model_route)) {
            return $this->getContainer()->getModelRoute($name, ...$args);
        }
        return panel()->route($this->model_route . '.' . $name, ...$args);
    }
}
