<?php

namespace Merlion\Components\Concerns;

trait LazyRenderable
{
    public function getUrl(): string
    {
        return panel()->route('api.render', array_merge($this->get(), ['class' => static::class]));
    }
}
