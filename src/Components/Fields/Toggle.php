<?php

namespace Merlion\Components\Fields;

class Toggle extends Field
{
    protected mixed $view = 'merlion::components.fields.toggle';


    public function getValueFromRequest()
    {
        return request($this->getName()) === 'on';
    }
}
