<?php

namespace Merlion\Components\Concerns\Panel;

trait HasLang
{
    public function getCurrentLanguage()
    {
        return session()->get('locale');
    }

    public function setCurrentLanguage($lang): static
    {
        session()->put('locale', $lang);
        return $this;
    }

    public function updateAppLocale(): static
    {
        if ($lang = $this->getCurrentLanguage()) {
            app()->setLocale($lang);
        }
        return $this;
    }
}
