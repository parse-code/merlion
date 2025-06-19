<?php

namespace Merlion\Http\Controllers\Api;

use Merlion\Components\Renderable;

class RenderController
{
    public function __invoke()
    {
        $class = request('class');
        if (class_exists($class)) {
            $content = $class::make()->set(request()->all());
            return $content->render();
        }
        return request()->all();
    }
}
