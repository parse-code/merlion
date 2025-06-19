<?php

namespace Merlion\Components\Table;

use Illuminate\Database\Eloquent\Model;
use Merlion\Components\Renderable;
use Merlion\Components\Table\Columns\Actions;
use Merlion\Components\Table\Columns\Column;
use Merlion\Components\Table\Columns\Image;
use Merlion\Components\Table\Columns\Text;

class Table extends Renderable
{
    protected mixed $view = 'merlion::components.table.table';
    protected iterable $rows = [];
    protected bool $paginate = true;
    protected int $perPage = 15;
    protected bool $selectable = false;

    protected Actions $actions;

    const __COMPONENT_COLUMNS = 'columns';
    const __COMPONENT_FILTERS = 'filters';
    const __COMPONENT_ACTIONS = 'actions';
    const __COMPONENT_TOOLS   = 'tools';

    public function columns($columns): static
    {
        $this->components($columns, static::__COMPONENT_COLUMNS);
        return $this;
    }

    public function paginate($paginate = true): static
    {
        $this->paginate = $paginate;
        return $this;
    }

    public function perPage($perPage): static
    {
        $this->perPage = $perPage;
        return $this;
    }

    public function text(...$args): Text
    {
        $column = Text::make(...$args);
        $this->columns($column);
        return $column;
    }

    public function image(...$args): Image
    {
        $column = Image::make(...$args);
        $this->columns($column);
        return $column;
    }

    public function actions($actions): static
    {
        return $this->components($actions, static::__COMPONENT_ACTIONS);
    }

    public function getActions(): array
    {
        return $this->getComponents(static::__COMPONENT_ACTIONS);
    }

    public function tools($tools): static
    {
        $this->components($tools, static::__COMPONENT_TOOLS);
        return $this;
    }

    public function getTools(): array
    {
        return $this->getComponents(static::__COMPONENT_TOOLS);
    }

    public function getColumns(): iterable
    {
        return $this->getComponents(static::__COMPONENT_COLUMNS);
    }

    public function filters($filters): static
    {
        $this->components($filters, static::__COMPONENT_FILTERS);
        return $this;
    }

    public function getFilters(): iterable
    {
        return $this->getComponents(static::__COMPONENT_FILTERS);
    }

    public function getRows()
    {
        $builder = $this->getBuilder();

        if ($this->paginate) {
            return $builder?->paginate($this->perPage)->appends(request()->query()) ?? [];
        }
        return $builder?->get() ?? [];
    }

    public function getBuilder()
    {
        $model = $this->getModel();

        if (is_string($model)) {
            /** @var Model $model */
            $builder = $model::query();
        } else {
            $builder = $model;
        }

        $builder = $this->applyFilters($builder);
        $builder = $this->applySort($builder);
        return $builder;
    }

    protected function applyFilters($builder)
    {
        $filters = $this->getFilters();
        foreach ($filters as $filter) {
            $builder = $filter->applyFilter($builder);
        }
        return $builder;
    }

    protected function applySort($builder)
    {
        if (empty(request('sort_by'))) {
            return $builder;
        }
        $columns = $this->getColumns();
        foreach ($columns as $column) {
            /** @var Column $column */
            if ($column->isSortable() && request('sort_by') == $column->getName()) {
                $builder = $column->applySort($builder);
            }
        }
        return $builder;
    }

    public function getPaginator()
    {
        $models = $this->getRows();

        if (empty($models)) {
            return null;
        }

        if (method_exists($models, 'links')) {
            return $models->links();
        }

        return null;
    }

    public function selectable($selectable = true): static
    {
        $this->selectable = $selectable;
        return $this;
    }

    public function isSelectable(): bool
    {
        return $this->selectable;
    }
}
