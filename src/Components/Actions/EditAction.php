<?php

namespace Merlion\Components\Actions;

class EditAction extends Link
{
    public function setupActions(): void
    {
        $this->label(__('merlion::base.edit'))
            ->class('btn btn-xs btn-soft-primary')
            ->icon('ri-edit-line')
            ->link(function (EditAction $action) {
                return $action->getContainer()->getModelRoute('edit', $action->getModelKey());
            });
    }
}
