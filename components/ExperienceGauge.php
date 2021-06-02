<?php namespace SunLab\LevelUp\Components;

use Cms\Classes\ComponentBase;
use SunLab\LevelUp\Models\Level;
use Winter\User\Facades\Auth;
use Winter\User\Models\User;

class ExperienceGauge extends ComponentBase
{
    public $nextLevel;
    public $userLevel;
    public $gaugeFillingRate = 0;

    public function onRender()
    {
        $this->addCss('components/experiencegauge/assets/style.css');

        if ($this->property('logged-user')) {
            $user = Auth::user();
        } else {
            $userId = $this->property('user-id');
            $user = User::find($userId);
        }

        $this->userLevel = $user->lastLevelReached;
        $this->nextLevel = Level::query()->where('level', $this->userLevel->level + 1)->first();

        if ($this->nextLevel) {
            $currentLevelExperienceRange = $this->nextLevel->experience_needed  - $this->userLevel->experience_needed;
            $userCurrentLevelAdvancement = $this->userLevel->pivot->experience - $this->userLevel->experience_needed;

            $this->gaugeFillingRate = 100 * $userCurrentLevelAdvancement / $currentLevelExperienceRange;
        } else {
            $this->gaugeFillingRate = 100;
        }
    }

    public function componentDetails()
    {
        return [
            'name'        => 'sunlab.levelup::lang.components.experience_gauge',
            'description' => 'sunlab.levelup::lang.components.experience_gauge_description'
        ];
    }

    public function defineProperties()
    {
        return [
            'user-id' => [
                'title'       => 'sunlab.levelup::lang.components.user_id',
                'description' => 'sunlab.levelup::lang.components.user_id_description',
                'default'     => '{{ :id }}',
                'type'        => 'string',
            ],
            'logged-user' => [
                'title'       => 'sunlab.levelup::lang.components.logged_user',
                'description' => 'sunlab.levelup::lang.components.logged_user_description',
                'type'        => 'checkbox',
            ],
        ];
    }
}
