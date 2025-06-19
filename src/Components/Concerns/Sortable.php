<?php

namespace Merlion\Components\Concerns;

trait Sortable
{
    private int $order = 0;

    public function order($order): static
    {
        $this->order = $order;
        return $this;
    }

    public static function sort(array $items): array
    {
        return collect($items)->sort(function ($a, $b) {
            return $a->order <=> $b->order;
        })->toArray();
    }
}
