<?php

namespace Merlion;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Merlion\Commands\InstallCommand;
use Merlion\Components\Widgets\LanguageSwitcher;
use Merlion\Http\Middleware\HandleInertiaRequests;
use Merlion\Http\Middleware\SetupPanel;

class MerlionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();
        $this->registerBindings();
    }

    public function boot(): void
    {
        $this->registerMiddlewares();
        $this->registerAssets();
        $this->registerPanelComponents();

        if ($this->app->runningInConsole()) {
            $this->registerPublications();
            $this->registerCommands();
        }
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/merlion.php', 'merlion');
    }

    private function registerBindings(): void
    {
        app()->scoped('merlion', function (): MerlionManager {
            return new MerlionManager();
        });
    }

    protected function registerPublications(): void
    {
        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('vendor/merlion'),
        ], 'merlion-assets');
    }

    private function registerCommands(): void
    {
        $this->commands([
            InstallCommand::class,
        ]);
    }

    private function registerAssets(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'merlion');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'merlion');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    private function registerMiddlewares(): void
    {
        app(Router::class)->aliasMiddleware('panel', SetupPanel::class);
        app(Router::class)->aliasMiddleware('inertia', HandleInertiaRequests::class);
    }

    private function registerPanelComponents(): void
    {
        if (config('merlion.multiple_langugae')) {
            panel()->addFilter('nav_top_right', function ($components = []) {
                $components[] = LanguageSwitcher::make();
                return $components;
            });
        }
    }
}
