<?php

namespace Merlion\Components;

use Merlion\Components\Fields\Field;
use Merlion\Components\Fields\File;

class Form extends Renderable
{
    protected mixed $view = 'merlion::components.form';
    protected mixed $action = '';
    protected mixed $method = 'post';
    protected array $fields = [];

    const __ACTIONS = 'actions';
    const __FIELDS  = 'fields';

    public function action($action): static
    {
        $this->action = $action;
        return $this;
    }

    public function method($method): static
    {
        $this->method = $method;
        return $this;
    }

    public function getAction(): string
    {
        return $this->evaluate($this->action);
    }

    public function getMethod(): string
    {
        return $this->evaluate($this->method);
    }

    public function fields($fields): static
    {
        return $this->components($fields, static::__FIELDS);
    }

    public function getFields(): array
    {
        return $this->getComponents(static::__FIELDS);
    }

    public function hasFiles(): static
    {
        return $this->withAttributes(['enctype' => 'multipart/form-data']);
    }

    public function buildFields(): void
    {
        $fields = $this->getFlatFields();
        foreach ($fields as $field) {
            $field->build();
        }
    }

    public function getFlatFields($parent = null)
    {
        $fields = [];
        if (empty($parent)) {
            $components = $this->getComponents(static::__FIELDS);
        } else {
            $components = $parent->getComponents();
        }
        foreach ($components ?? [] as $child) {
            if ($child instanceof Field) {
                $child->set('form', $this);
                if ($child instanceof File) {
                    $this->hasFiles();
                }
                $fields[] = $child;
            } elseif (is_array($child)) {
                foreach ($child as $sub_child) {
                    $fields = array_merge($fields, $this->getFlatFields($sub_child));
                }
            } elseif (!empty($child->getComponents())) {
                $fields = array_merge($fields, $this->getFlatFields($child));
            }
        }
        $this->fields = $fields;
        return $fields;
    }

    public function validate(): array
    {
        $fields = $this->getFlatFields();
        $rules  = [];
        foreach ($fields as $field) {
            $rules[$field->getName()] = $field->getRules();
        }

        request()->validate($rules);
        $data = [];
        foreach ($fields as $field) {
            $data[$field->getName()] = $field->getValueFromRequest();
        }
        return $data;
    }

    public function actions($actions): static
    {
        $this->components($actions, static::__ACTIONS);
        return $this;
    }

    public function getActions(): array
    {
        return $this->getComponents(static::__ACTIONS) ?? [];
    }
}
