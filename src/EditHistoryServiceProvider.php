<?php

namespace MahmoudArafat\EditHistory;

use Illuminate\Support\ServiceProvider;

class EditHistoryServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'history-views');
        $this->publishes([
            __DIR__.'/config/edit-history.php' => base_path('config/edit-history.php'),
           // __DIR__.'/views' => base_path('resources/views/mahmoud-arafat/edit-history'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */

    public function register()
    {
        //$this->app->make('MahmoudArafat\EditHistory\Controllers\EditHistoryController');
    }
}
