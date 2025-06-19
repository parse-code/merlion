<?php

namespace Merlion\Components\Concerns;

use Illuminate\Support\Str;

trait HasId
{
    protected string $id;

    public function id($id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): string
    {
        return $this->id ?? $this->defaultId();
    }

    protected function defaultId(): string
    {
        $this->id = Str::slug(class_basename(static::class)) . '_' . uniqid();
        return $this->id;
    }
}
