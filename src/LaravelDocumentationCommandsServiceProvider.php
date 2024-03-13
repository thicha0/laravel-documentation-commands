<?php

namespace Thicha0\LaravelDocumentationCommands;

use Illuminate\Support\ServiceProvider;
use Thicha0\LaravelDocumentationCommands\GenerateDocumentationCommands;

class LaravelDocumentationCommandsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
              GenerateDocumentationCommands::class,
            ]);
        }
        $this->loadViewsFrom(__DIR__.'/views', 'laravel-documentation-commands');
    }
}
