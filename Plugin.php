<?php namespace SunLab\LevelUp;

use Backend\Facades\Backend;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;

/**
 * LevelUp Plugin Information File
 */
class Plugin extends PluginBase
{
    public $require = [
        'Winter.User',
        'SunLab.Measures'
    ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'LevelUp',
            'description' => 'No description provided yet...',
            'author'      => 'SunLab',
            'icon'        => 'icon-leaf'
        ];
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
            'SunLab\LevelUp\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'sunlab.levelup.manage_experience_increasers' => [
                'tab' => 'LevelUp',
                'label' => 'Some permission'
            ],
            'sunlab.levelup.manage_levels' => [
                'tab' => 'LevelUp',
                'label' => 'Some permission'
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'experience_increasers' => [
                'label' => 'sunlab.levelup::lang.settings.experience_increasers.name',
                'description' => 'sunlab.levelup::lang.settings.experience_increasers.description',
                'category' => SettingsManager::CATEGORY_USERS,
                'icon' => 'icon-line-chart',
                'url' => Backend::url('sunlab/levelup/experienceincreasers'),
                'order' => 500,
                'permissions' => ['sunlab.levelup.manage_experience_increasers']
            ],
            'levels' => [
                'label' => 'sunlab.levelup::lang.settings.levels.name',
                'description' => 'sunlab.levelup::lang.settings.levels.description',
                'category' => SettingsManager::CATEGORY_USERS,
                'icon' => 'icon-signal',
                'url' => Backend::url('sunlab/levelup/levels'),
                'order' => 500,
                'permissions' => ['sunlab.levelup.manage_levels']
            ]
        ];
    }
}
