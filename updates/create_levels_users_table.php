<?php namespace SunLab\LevelUp\Updates;

use Winter\Storm\Support\Facades\Schema;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;

class CreateLevelsUsersTable extends Migration
{
    public function up()
    {
        Schema::create('sunlab_levelup_levels_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('level_id');
            $table->unsignedInteger('experience');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sunlab_levelup_levels_users');
    }
}
