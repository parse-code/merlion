<?php

namespace Merlion\Http\Controllers\Api;

use Storage;

class UploadController
{
    public function __invoke()
    {
        $name      = request()->input('name', 'file');
        $url_field = request()->input('url_field', 'location');
        $file      = request()->file($name);
        $url       = Storage::url($file->store());
        return [
            $url_field => $url,
        ];
    }
}
