<?php

namespace Merlion\Components\Table\Columns;

use Illuminate\Support\Str;
use Merlion\Components\Concerns\Copyable;
use Merlion\Components\Concerns\HasLink;

class Text extends Column
{
    use HasLink;
    use Copyable;

    protected mixed $labels;
    protected mixed $colors;
    protected mixed $mask;

    protected mixed $view = 'merlion::components.table.columns.text';

    public function labels($labels): static
    {
        $this->labels = $labels;
        return $this;
    }

    public function colors($colors): static
    {
        $this->colors = $colors;
        return $this;
    }

    public function mask($mask = [6, -4]): static
    {
        $this->mask = $mask;
        return $this;
    }

    public function getValue()
    {
        $value  = parent::getValue();
        $result = $value;
        if (!empty($this->labels)) {
            $result = $this->evaluate($this->labels)[$value] ?? '';
        }

        if (!empty($this->mask)) {
            if (!empty($result)) {
                $result = Str::substr($result, 0, $this->mask[0]) . '****' . Str::substr($result, $this->mask[1]);
            }
        }

        if (!empty($this->colors)) {
            $color  = $this->evaluate($this->colors)[$value] ?? ($this->evaluate($this->colors)['default'] ?? 'primary');
            $result = '<span class="badge bg-' . $color . '">' . $result . '</span>';
        }

        return $result;
    }
}
