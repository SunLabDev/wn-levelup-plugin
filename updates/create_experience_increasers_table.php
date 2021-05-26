<?php namespace SunLab\LevelUp\Updates;

use Winter\Storm\Support\Facades\Schema;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;

class CreateExperienceIncreasersTable extends Migration
{
    public function up()
    {
        Schema::create('sunlab_levelup_experience_increasers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('measure_name');
            $table->unsignedInteger('points');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sunlab_levelup_experience_increasers');
    }
}
