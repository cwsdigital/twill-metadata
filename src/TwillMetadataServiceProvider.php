<?php

namespace CwsDigital\TwillMetadata;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class TwillMetadataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/metadata.php', 'metadata'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'twill-metadata');
        $this->extendBlade();

        $this->publishes([
            __DIR__.'/config/metadata.php' => config_path('metadata.php'),
            __DIR__.'/config/seotools.php' => config_path('seotools.php')
        ], 'config');
    }

    private function extendBlade() {
        Blade::include('twill-metadata::includes.metadata-fields', 'metadataFields');
        Blade::include('twill-metadata::includes.metadata-settings', 'metadataSettings');
    }
}
