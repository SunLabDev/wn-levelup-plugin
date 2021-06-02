<?php namespace SunLab\LevelUp\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;
use Illuminate\Support\Facades\Lang;
use SunLab\LevelUp\Models\Level;
use System\Classes\SettingsManager;
use Winter\Storm\Database\Builder;
use Winter\Storm\Exception\ApplicationException;
use Winter\Storm\Exception\ValidationException;
use Winter\Storm\Support\Facades\Flash;

/**
 * Levels Back-end Controller
 */
class Levels extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Winter.System', 'system', 'settings');
        SettingsManager::setContext('SunLab.LevelUp', 'levels');
    }

    public function index()
    {
        $allLevels =
            Level::query()
                 ->orderBy('level')
                 ->get()
                 ->keyBy('level')
                 ->keys();

        $this->vars['missingLevels'] = collect(range(1, $allLevels->last()))->diff($allLevels)->toArray();

        return parent::index();
    }

    public function update($modelId)
    {
        $updatedLevel = Level::query()->findOrFail($modelId);

        if ($updatedLevel->level === 1) {
            return $this->preview($modelId);
        }

        return parent::update($modelId);
    }

    /**
     * Verify eventual conflictual levels
     * A level is conflictual if a lower level needs more experience or an higher needs less experience
     * Eg: Level 3 is conflictual if it needs only 200 experience point when level 2 needs 500
     * @throws ApplicationException
     */
    public function formBeforeSave()
    {
        $conflictualLevels =
            Level::query()
                 ->where([
                     ['level', '<', post('Level[level]')],
                     ['experience_needed', '>', post('Level[experience_needed]')],
                 ])
                 ->orWhere([
                     ['level', '>', post('Level[level]')],
                     ['experience_needed', '<', post('Level[experience_needed]')],
                 ])
                 ->get();

        if ($conflictualLevels->isNotEmpty()) {
            $firstConflictualLevel = $conflictualLevels->first();

            throw new ApplicationException(
                Lang::get('sunlab.levelup::lang.errors.conflictual_level', [
                    'level' => $firstConflictualLevel->level,
                    'experience_needed' => $firstConflictualLevel->experience_needed
                ])
            );
        }
    }

    public function update_onDelete($modelId)
    {
        $deletedLevel = Level::query()->findOrFail($modelId);

        if ($deletedLevel->level === 1) {
            throw new ApplicationException(
                Lang::get('sunlab.levelup::lang.errors.level_one_cant_be_deleted')
            );
        }
        return parent::update_onDelete($modelId);
    }
}
