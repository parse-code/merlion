<?php

namespace Merlion\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Merlion\Components\Inertia;

class HandleInertiaRequests extends Middleware
{
    public function rootView(Request $request): string
    {
        return Inertia::$rootView;
    }

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
        ];
    }
}
