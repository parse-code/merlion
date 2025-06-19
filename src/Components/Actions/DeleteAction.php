<?php

namespace Merlion\Components\Actions;

use Merlion\Components\Concerns\BelongsToTable;

class DeleteAction extends Action
{
    public function setupActions(): void
    {
        $this->label(__('merlion::base.delete'))
            ->class('btn btn-xs btn-soft-danger')
            ->icon('ri-delete-bin-line')
            ->data('action', function ($action) {
                return $action->getContainer()->getModelRoute('destroy', $action->getModelKey());
            })
            ->data('confirm', 'Are you sure?')
            ->data('after', 'refresh')
            ->data('method', 'delete');
    }
}
