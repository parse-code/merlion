<?php

namespace Merlion\Components\Actions;

class LazyFormAction extends Action
{
    protected mixed $view = 'merlion::components.actions.lazy_form_action';

    protected mixed $form;

    public function form($form): static
    {
        $this->form = $form;
        return $this;
    }
}
