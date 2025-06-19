<?php

use Illuminate\Support\Facades\Route;
use Merlion\Components\Panel;
use Merlion\Http\Controllers\Api\FormController;
use Merlion\Http\Controllers\Api\ModelController;
use Merlion\Http\Controllers\Api\RenderController;
use Merlion\Http\Controllers\Api\UploadController;
use Merlion\Http\Controllers\AuthController;
use Merlion\Http\Controllers\DashboardController;
use Merlion\Http\Middleware\Authenticate;

Route::name('merlion.')
    ->group(function (): void {
        foreach (merlion()->panels() as $panel) {
            /** @var Panel $panel */
            Route::middleware($panel->getMiddleware())
                ->name($panel->getId() . '.')
                ->prefix($panel->getPath())
                ->group(function () use ($panel) {

                    if ($panel->withLogin()) {
                        Route::get('login', [AuthController::class, 'getLoginPage'])->name('login');
                        Route::post('login', [AuthController::class, 'submitLogin'])->name('submit-login');
                        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
                    }

                    if (config('merlion.multiple_langugae')) {
                        Route::get('lang/{lang}', function ($lang) use ($panel) {
                            $panel->setCurrentLanguage($lang);
                            return back();
                        })->name('lang');
                    }

                    Route::group(['middleware' => Authenticate::class],
                        function () use ($panel) {
                            Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
                                Route::get('model', [ModelController::class, 'search'])->name('model');
                                Route::get('render', RenderController::class)->name('render');
                                Route::post('form', FormController::class)->name('form');
                                Route::post('upload', UploadController::class)->name('upload');
                            });

                            foreach ($panel->getRoutes() as $routes) {
                                if (is_callable($routes)) {
                                    $routes($panel);
                                }
                                if (is_string($routes)) {
                                    require $routes;
                                }
                            }

                            Route::get('', DashboardController::class)->name('dashboard');
                        });
                });
        }
    });
