<?php

namespace Merlion\Support;

use Illuminate\Database\Eloquent\Relations\Relation;

class ModelHelper
{
    public static function getRelationshipModels($model, $relationship): Relation
    {
        return $model->{$relationship}();
    }
}
