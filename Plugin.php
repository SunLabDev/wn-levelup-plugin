<?php namespace SunLab\LevelUp;

use Backend\Facades\Backend;
use SunLab\LevelUp\Models\ExperienceIncreaser;
use SunLab\LevelUp\Models\Level;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;
use Winter\Storm\Support\Facades\Event;
use Winter\User\Models\User;

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
        $this->extendsUserModel();
        $this->listenForMeasuresEvents();
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

    protected function extendsUserModel()
    {
        User::extend(function ($user) {
            if (!$user->isClassExtendedWith('SunLab.Measures.Behaviors.Measurable')) {
                $user->extendClassWith('SunLab.Measures.Behaviors.Measurable');
            }

            $user->belongsToMany['levels'] = [
                Level::class,
                'table' => 'sunlab_levelup_levels_users',
                'pivot' => ['id', 'experience'],
                'timestamps' => true
            ];

            $user->addDynamicMethod('getLevelAttribute', function () use ($user) {
                return $user->levels()
                        ->orderByDesc('level')
                        ->first()
                        ->level ?? 1;
            });

            $user->addDynamicMethod('getExperienceAttribute', function () use ($user) {
                return $user->levels()
                        ->orderByDesc('level')
                        ->first()
                        ->pivot
                        ->experience ?? 0;
            });
        });
    }

    protected function listenForMeasuresEvents()
    {
        Event::listen('sunlab.measures.incrementMeasure', static function ($model, $measure, $amount) {
            if (!$model instanceof User) {
                return;
            }

            $experienceIncreaser = ExperienceIncreaser::query()->firstWhere('measure_name', $measure->name);

            if (!$experienceIncreaser) {
                return;
            }

            $pointsIncrease = $experienceIncreaser->points * $amount;

            $userLevel =
                $model->levels()
                    ->orderByDesc('level')
                    ->first();

            if ($userLevel) {
                $userLevel->flushDuplicateCache();
                $userLevel->pivot->increment('experience', $pointsIncrease);
                $currentLevel = $userLevel->level;
                $newExperience = $userLevel->pivot->experience;
            } else {
                $firstLevel = Level::query()->firstWhere('level', 1);
                if ($firstLevel) {
                    $model->levels()->syncWithoutDetaching([$firstLevel->id => ['experience' => $pointsIncrease]]);
                    $currentLevel = $firstLevel->level;
                    $newExperience = $pointsIncrease;
                }
            }

            if (!isset($currentLevel)) {
                return;
            }

            Event::fire('sunlab.levelup.experienceIncreased', [$model, $newExperience, $pointsIncrease]);

            $nextLevelsReached =
                Level::query()
                     ->where([
                         ['experience_needed', '<=', $newExperience],
                         ['level', '>', $currentLevel]
                     ])
                     ->get();

            if ($nextLevelsReached->isNotEmpty()) {
                $reachedLevelsRelations = $nextLevelsReached->mapWithKeys(
                    static function ($level) use ($newExperience) {
                        return [$level->id => ['experience' => $newExperience]];
                    }
                );

                $model->levels()->syncWithoutDetaching($reachedLevelsRelations);

                $nextLevelsReached->sortBy('level')->each(static function ($levelReached) use ($model) {
                    Event::fire('sunlab.levelup.levelUp', [$model, $levelReached->level]);
                });
            }
        });
    }
}
