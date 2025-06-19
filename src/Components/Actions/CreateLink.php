<?php

namespace Merlion\Components\Actions;

class CreateLink extends Link
{
    public function setupCreateLink(): void
    {
        $this->label(__('merlion::base.create'))
            ->icon('ri-add-line')
            ->class('btn btn-primary')
            ->link(function ($link) {
                return $link->getContainer()->getModelRoute('create');
            });
    }
}
