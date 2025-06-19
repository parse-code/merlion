<?php

namespace Merlion\Components\Concerns;

trait HasColor
{
    protected mixed $color = 'primary';

    const COLOR_PRIMARY   = 'primary';
    const COLOR_SECONDARY = 'secondary';
    const COLOR_SUCCESS   = 'success';
    const COLOR_DANGER    = 'danger';
    const COLOR_WARNING   = 'warning';
    const COLOR_INFO      = 'info';
    const COLOR_LIGHT     = 'light';
    const COLOR_DARK      = 'dark';

    public function color($color): static
    {
        $this->color = $color;
        return $this;
    }

    public function getColor(): string|null
    {
        return $this->evaluate($this->color);
    }

    public function colorPrimary(): static
    {
        return $this->color(self::COLOR_PRIMARY);
    }

    public function colorSecondary(): static
    {
        return $this->color(self::COLOR_SECONDARY);
    }

    public function colorSuccess(): static
    {
        return $this->color(self::COLOR_SUCCESS);
    }

    public function colorDanger(): static
    {
        return $this->color(self::COLOR_DANGER);
    }

    public function colorWarning(): static
    {
        return $this->color(self::COLOR_WARNING);
    }

    public function colorInfo(): static
    {
        return $this->color(self::COLOR_INFO);
    }

    public function colorLight(): static
    {
        return $this->color(self::COLOR_LIGHT);
    }

    public function colorDark(): static
    {
        return $this->color(self::COLOR_DARK);
    }


}
