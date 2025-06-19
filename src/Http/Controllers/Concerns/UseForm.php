<?php

namespace Merlion\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Model;
use Merlion\Components\Actions\Action;
use Merlion\Components\Card;
use Merlion\Components\Fields\Field;
use Merlion\Components\Flex;
use Merlion\Components\Form;

trait UseForm
{
    public function create()
    {
        $card = Card::make();
        $form = $this->getForm();
        $card->body($form);
        return panel()
            ->backUrl($this->getRoute('index'))
            ->pageTitle(__('merlion::base.create') . ' ' . $this->getLabel())->content($card);
    }

    public function edit($id)
    {
        $model = $this->getModel($id);
        $card  = Card::make();
        $form  = $this->getForm($id);
        $card->modelRoute($this->route)->model($model);
        $card->header(Flex::make($form->getActions()));
        $card->body($form);
        return panel()
            ->backUrl($this->getRoute('index'))
            ->pageTitle(__('merlion::base.edit') . ' ' . $this->getLabel())
            ->content($card);
    }

    public function store()
    {
        $form  = $this->getForm();
        $model = $this->submit($form);
        return redirect($this->getRoute('edit', $model->getKey()));
    }

    public function update(...$args)
    {
        $form = $this->getForm(...$args);
        $this->submit($form);
        panel()->success(__('merlion::base.action_success'));
        return back();
    }

    protected function submit(Form $form)
    {
        $form->validate();

        $model  = $form->getModel();
        $fields = $form->getFlatFields();
        if (!($model instanceof Model)) {
            $model = new $model;
        }
        foreach ($fields as $field) {
            /** @var Field $field */
            $model = $field->processSave($model);
        }
        $model->save();
        return $model;
    }

    protected function getForm($id = null): Form
    {
        $model = $this->getModel($id);

        if ($id) {
            $action = $this->getRoute('update', $id);
            $method = 'put';
        } else {
            $action = $this->getRoute('store');
            $method = 'post';
        }

        $form = Form::make()
            ->model($model)
            ->modelRoute($this->route)
            ->action($action)
            ->method($method);

        if (method_exists($this, 'form')) {
            $this->form($form);
        }
        $form->fields(Action::make('submit', __('merlion::base.submit'))->class('btn mt-3 btn-primary'));
        return $form;
    }


    public function destroy(...$args)
    {
        $model = $this->getModel(...$args);
        if ($model) {
            $model->delete();
            panel()->success(__('merlion::base.action_success'));
        }
        return [
            'action' => 'redirect',
            'url'    => $this->getRoute('index'),
        ];
    }
}
