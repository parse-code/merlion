<?php

namespace Merlion\Http\Controllers\Api;
class FormController
{
    public function __invoke()
    {
        $class = request('class');
        if (class_exists($class)) {
            $content = $class::make()->set(request()->all());
            return $content->submit();
        }
        return request()->all();
    }
}
