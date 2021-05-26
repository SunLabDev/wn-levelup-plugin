<?php namespace SunLab\LevelUp\Tests\Unit\Facades;

use SunLab\LevelUp\Tests\LevelUpPluginTestCase;

class LevelUpTest extends LevelUpPluginTestCase
{
    public function testUserExperienceIsIncreased()
    {
        self::assertEquals(0, $this->user->experience);

        $this->user->incrementMeasure('topic_posted');
        $this->user->incrementMeasure('topic_posted');
        $this->user->incrementMeasure('topic_posted');

        self::assertEquals(30, $this->user->experience);

        $this->user->incrementMeasure('topic_posted', 3);

        self::assertEquals(80, $this->user->experience);
    }

    public function testUserLevelsUp()
    {
        // Get 40 experience points, still level 0
        $this->user->incrementMeasure('topic_posted', 4);
        self::assertEquals(0, $this->user->level);

        // Get 50 experience points, level up to level 1
        $this->user->incrementMeasure('topic_posted');
        self::assertEquals(1, $this->user->level);

        // Get 150 experience points, level up to level 2
        $this->user->incrementMeasure('topic_posted', 10);
        self::assertEquals(2, $this->user->level);
    }
}
