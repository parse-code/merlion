<?php

namespace Merlion\Http\Controllers;

class DashboardController
{
    public function __invoke()
    {
        $dashboard = panel()->doFilters('dashboard', []);
        if (empty($dashboard)) {
            $dashboard = '<div class="alert alert-info">You can customize dashboard by use panel()->addFilter("dashboard")</div>';
        }
        return panel()->pageTitle('Dashboard')->content($dashboard);
    }
}
