<?php namespace Mercator\ThemeUpdater\Classes;

class ThemeUpdaterServiceProvider extends \Winter\Storm\Support\ServiceProvider
{
    public function register()
    {
        $this->app['config']['filesystems.disks.themes'] = [
            'driver' => 'local',
            'root'   => themes_path()
        ];

        $this->commands([
            \Mercator\ThemeUpdater\Console\Copy::class,
            \Mercator\ThemeUpdater\Console\Update::class
        ]);
    }
}
