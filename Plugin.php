<?php namespace Mercator\ThemeUpdater;

use Backend;
use System\Classes\PluginBase;


/**
 * ThemeUpdater Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Theme Updater',
            'description' => 'Execute commands when installing or updating themes, e.g. to save data',
            'author'      => 'Helmut Kaufmann',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    	$this->registerConsoleCommand('theme:copy', 'Mercator\ThemeUpdater\Console\Copy');
    	$this->registerConsoleCommand('theme:update', 'Mercator\ThemeUpdater\Console\Update');

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Mercator\ThemeUpdater\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'mercator.themeupdater.some_permission' => [
                'tab' => 'ThemeUpdater',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'themeupdater' => [
                'label'       => 'ThemeUpdater',
                'url'         => Backend::url('mercator/themeupdater/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['mercator.themeupdater.*'],
                'order'       => 500,
            ],
        ];
    }
}
