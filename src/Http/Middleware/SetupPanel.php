<?php

namespace Merlion\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SetupPanel
{
    public function handle(Request $request, Closure $next, string $panel): mixed
    {
        $panel = panel($panel);
        merlion()->setCurrentPanel($panel);
        merlion()->bootCurrentPanel();
        panel()->updateAppLocale();
        return $next($request);
    }
}
