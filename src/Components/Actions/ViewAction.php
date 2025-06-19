<?php

namespace Merlion\Components\Actions;

use Merlion\Components\Concerns\BelongsToTable;

class ViewAction extends Link
{
    public function setupActions(): void
    {
        $this->label(__('merlion::base.view'))
            ->class('btn btn-xs btn-soft-primary')
            ->icon('ri-eye-line')
            ->link(function (ViewAction $action) {
                return $action->getContainer()->getModelRoute('show', $action->getModelKey());
            });
    }
}
