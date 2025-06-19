<?php

namespace Merlion\Components\Concerns\Panel;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;
use Merlion\Components\Css;
use Merlion\Components\Script;

trait HasAssets
{
    protected string $cspNonce = '';

    protected array $defaultAssest = [
        'css' => [
            '/css/bootstrap.min.css',
            '/css/icons.min.css',
            '/css/app.min.css',
            '/css/custom.min.css',
        ],
        'js'  => [
            '/libs/jquery/jquery.min.js',
            '/js/layout.js',
            '/libs/bootstrap/js/bootstrap.bundle.min.js',
            '/libs/simplebar/simplebar.min.js',
            '/libs/node-waves/waves.min.js',
            '/libs/feather-icons/feather.min.js',
            '/libs/toastify-js/src/toastify.js',
            '/js/pages/plugins/lord-icon-2.1.0.js',
        ],
    ];

    public function nonce($nonce): static
    {
        $this->cspNonce = $nonce;
        return $this;
    }

    public function getNonce(): string
    {
        return $this->cspNonce;
    }

    public function script($script): static
    {
        if (is_string($script)) {
            $script = Script::make()->src($script);
        }
        return $this->components($script, 'scripts');
    }

    public function getScripts()
    {
        return $this->getComponents('scripts');
    }

    public function getCss()
    {
        return $this->getComponents('css');
    }

    public function theme($theme = 'default'): static
    {
        if (is_string($theme)) {
            $theme = [
                'theme' => $theme,
            ];
        }
        $data = array_merge([
            'theme'   => 'default',
            'layout'  => 'vertical',
            'sidebar' => 'dark',
        ], $theme);
        return $this->data($data, 'html');
    }

    public function asset($url, $secure = null)
    {
        if (Str::isUrl($url)) {
            return $url;
        }
        $url = Str::replaceStart('/', '', $url);
        return asset('/vendor/merlion/' . $url, $secure);
    }

    protected function buildHasAssets(): void
    {
        foreach ($this->defaultAssest['css'] as $href) {
            $css = Css::make()->href($this->asset($href));
            $this->components($css, 'css');
        }

        foreach ($this->defaultAssest['js'] as $src) {
            $this->script($this->asset($src));
        }

        Paginator::useBootstrapFive();
    }

//    public function menus($menus): static
//    {
//        return $this->components($menus, 'menus');
//    }
//
//    public function getMenus(): array
//    {
//        return $this->getComponents('menus');
//    }
}
