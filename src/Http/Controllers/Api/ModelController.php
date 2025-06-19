<?php

namespace Merlion\Http\Controllers\Api;

class ModelController
{
    public function search()
    {
        $model  = request('model');
        $fields = request('fields', ['id', 'name']);
        return $model::select($fields)->get();
    }
}
