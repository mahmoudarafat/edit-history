<?php

namespace MahmoudArafat\EditHistory;

use Illuminate\Support\ServiceProvider;
use MahmoudArafat\EditHistory\Commands\tableCommand;
use MahmoudArafat\EditHistory\Controllers\EditHistoryController;

class EditHistoryServiceProvider extends ServiceProvider
{

    public function boot()
    {


        include __DIR__.'/routes/routes.php';
        include __DIR__.'/Classes/helpers.php';
	
		if(! file_exists(base_path('config/edit-history.php')))
		{
			$this->publishes([ __DIR__.'/config' => base_path('config')]);
		}

        if ($this->app->runningInConsole()) {
            $this->commands([
                tableCommand::class
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */

    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'history-views');

        $this->app->alias(EditHistoryController::class, 'EditHistory');
        
        $this->app->make('mahmoudarafat\edit-history\Controllers\EditHistoryController');

    }
}
