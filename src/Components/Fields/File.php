<?php

namespace Merlion\Components\Fields;

use Storage;

class File extends Field
{
    protected mixed $view = 'merlion::components.fields.file';

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

    public function getValueFromRequest()
    {
        $name  = $this->getName();
        $value = request()->input('old_' . $name);
        if ($this->isMultiple()) {
            $value = to_json($value) ?? [];
        }

        if (request()->hasFile($name)) {
            if ($this->isMultiple()) {
                $new_values = [];
                foreach (request()->file($name) as $file) {
                    $new_values[] = Storage::url($file->store());
                }
                $value = array_merge($value, $new_values);
            } else {
                $value = Storage::url(request()->file($name)->store());
            }
        }
        return $value;
    }
}
