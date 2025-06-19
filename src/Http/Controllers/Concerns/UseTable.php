<?php

namespace Merlion\Http\Controllers\Concerns;

use Merlion\Components\Table\Table;

trait UseTable
{
    public function index()
    {
        $table = Table::make()
            ->modelRoute($this->route);
        $this->table($table);
        if (empty($table->getModel())) {
            $table->model($this->model);
        }
        $this->callMethods('beforeIndex', '', $table);
        panel()->pageTitle($this->getLabelPlural())->content($table);
        $this->callMethods('afterIndex', '', $table);
        return panel();
    }
}
