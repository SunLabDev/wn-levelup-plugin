<?php namespace SunLab\LevelUp\Updates;

use Winter\Storm\Support\Facades\Schema;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;

class CreateLevelsTable extends Migration
{
    public function up()
    {
        Schema::create('sunlab_levelup_levels', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('level');
            $table->unsignedBigInteger('experience_needed');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sunlab_levelup_levels');
    }
}
