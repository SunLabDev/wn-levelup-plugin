<?php namespace SunLab\LevelUp\Updates;

use SunLab\LevelUp\Models\Level;
use Winter\Storm\Database\Updates\Seeder;

class SeedLevelsTable extends Seeder
{
    public function run()
    {
        Level::create([
            'level' => 1,
            'experience_needed' => 0
        ]);
    }
}
