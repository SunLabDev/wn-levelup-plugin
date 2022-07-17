<?php namespace SunLab\LevelUp\Tests;

use System\Tests\Bootstrap\PluginTestCase;
use SunLab\LevelUp\Models\ExperienceIncreaser;
use SunLab\LevelUp\Models\Level;
use Winter\User\Facades\Auth;

abstract class LevelUpPluginTestCase extends PluginTestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->getPluginObject()->boot();

        // Create a base use model for the tests
        $this->user = Auth::register([
            'username' => 'username',
            'email' => 'user@user.com',
            'password' => 'abcd1234',
            'password_confirmation' => 'abcd1234'
        ]);

        $experienceIncreaser = new ExperienceIncreaser();
        $experienceIncreaser->measure_name = 'topic_posted';
        $experienceIncreaser->points = 10;
        $experienceIncreaser->save();

        $levelOne = new Level();
        $levelOne->level = 2;
        $levelOne->experience_needed = 50;
        $levelOne->save();

        $levelTwo = new Level();
        $levelTwo->level = 3;
        $levelTwo->experience_needed = 150;
        $levelTwo->save();
    }
}
