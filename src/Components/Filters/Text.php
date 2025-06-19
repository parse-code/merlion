<?php

namespace Merlion\Components\Filters;

class Text extends Filter
{
    protected mixed $view = 'merlion::components.filters.text';

    protected array $search;

    public function search(...$args): static
    {
        if (is_array($args[0])) {
            $search = $args[0];
        } else {
            $search = $args;
        }
        $this->search = $search;
        return $this;
    }

    public function applyFilter($builder)
    {
        if (empty($this->getValue())) {
            return $builder;
        }
        if (empty($this->search)) {
            $fields = [$this->getName()];
        } else {
            $fields = $this->search;
        }
        return $builder->where(function ($query) use ($fields) {
            foreach ($fields as $field) {
                $query->orWhere($field, 'like', '%' . $this->getValue() . '%');
            }
        });
    }
}
