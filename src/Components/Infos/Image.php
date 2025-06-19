<?php

namespace Merlion\Components\Infos;

use Merlion\Components\Concerns\HasSize;

class Image extends Info
{
    use HasSize;

    protected mixed $view = 'merlion::components.infos.image';
    protected bool $multiple = false;

    public function multiple($multiple = true): static
    {
        $this->multiple = $multiple;
        return $this;
    }

    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    public function getValue()
    {
        $value = parent::getValue();
        if ($this->isMultiple()) {
            $value = to_json($value) ?? [];
        } else {
            if ($value) {
                $value = [$value];
            } else {
                $value = [];
            }
        }
        return $value;
    }
}
