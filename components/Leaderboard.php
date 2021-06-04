<?php namespace SunLab\LevelUp\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\DB;
use Winter\User\Models\User;

class Leaderboard extends ComponentBase
{
    public $users;

    public function onRender()
    {
        $this->addCss('components/leaderboard/assets/style.css');

        $orderedTopUsers =
            DB::table('sunlab_levelup_levels_users')
              ->distinct('user_id')
              ->orderByDesc('experience')
              ->limit($this->property('nb-users-to-display'))
              ->get(['user_id']);

        $orderedTopUsersId = $orderedTopUsers->pluck('user_id');
        $this->users =
            User::query()
                ->with(['levels' => static function ($query) {
                    return $query->orderByDesc('level')->first();
                }])
                ->whereIn('id', $orderedTopUsersId)
                ->get()
                ->sortBy(static function ($user) use ($orderedTopUsersId) {
                    return $orderedTopUsersId->search($user->id);
                });
    }

    public function componentDetails()
    {
        return [
            'name'        => 'Leaderboard',
            'description' => 'sunlab.levelup::lang.components.leaderboard_description'
        ];
    }

    public function defineProperties()
    {
        return [
            'nb-users-to-display' => [
                'title'       => 'sunlab.levelup::lang.components.nb_users_to_display',
                'default'     => '10',
                'type'        => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'The Max Items property can contain only numeric symbols'
            ]
        ];
    }
}
