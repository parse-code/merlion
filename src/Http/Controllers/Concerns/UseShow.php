<?php

namespace Merlion\Http\Controllers\Concerns;

use Merlion\Components\Card;
use Merlion\Components\InfoList;

trait UseShow
{
    public function show(...$args)
    {
        $model = $this->getModel(...$args);

        if (request('raw')) {
            return $model;
        }

        if (empty($model)) {
            return $this->empty();
        }

        $card = Card::make()
            ->modelRoute($this->route)
            ->model($model);

        $infolist = InfoList::make()->modelRoute($this->route)
            ->model($model);

        $this->infolist($infolist);

        $card->header($infolist->getActions());
        $card->body($infolist);

        return panel()
            ->backUrl($this->getRoute('index'))
            ->pageTitle(__('merlion::base.view') . ' ' . $this->getLabel())
            ->content($card);
    }
}
