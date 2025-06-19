<?php

namespace Merlion\Http\Controllers\Concerns;

use Illuminate\Support\Str;
use Merlion\Components\Renderable;
use Merlion\Concerns\CanCallMethods;
use Merlion\Crud;

/**
 * @property string $route
 * @property string $model
 * @property string $label
 * @property string $labelPlural
 */
trait AsAdmin
{
    use CanCallMethods;

    private ?Crud $crud;

    protected mixed $_model = null;

    protected function getCrud(): Crud
    {
        if (empty($this->crud)) {
            $this->crud = new Crud($this->model, $this->route);
        }
        return $this->crud;
    }

    protected function getModel($id = null)
    {
        if (empty($id)) {
            return $this->model;
        }
        if (empty($this->_model)) {
            $this->_model = $this->model::find($id);
        }
        return $this->_model;
    }

    protected function getLabel(): string
    {
        if (!empty($this->label)) {
            return $this->label;
        }

        $label = class_basename($this->model);
        $label = Str::snake($label, ' ');
        return Str::title($label);
    }

    protected function getLabelPlural(): string
    {
        if (!empty($this->labelPlural)) {
            return $this->labelPlural;
        }

        $label = $this->getLabel();
        return Str::plural($label);
    }

    public function getRoute($name, ...$args): string
    {
        return $this->getCrud()->getRoute($name, ...$args);
    }

    public function empty()
    {
        return panel()
            ->backUrl($this->getRoute('index'))
            ->pageTitle($this->getLabel())
            ->content(Renderable::make()
                ->class('alert alert-danger')
                ->components(__('merlion::base.content_not_found')));
    }
}
