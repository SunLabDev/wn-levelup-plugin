<?php namespace SunLab\LevelUp\Models;

use Winter\Storm\Database\Model;
use Winter\User\Models\User;

/**
 * Level Model
 */
class Level extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'sunlab_levelup_levels';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'level' => 'required|unique',
        'experience_needed' => 'required',
    ];

    public $timestamps = false;

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'users' => [User::class, 'table' => 'sunlab_levelup_levels_users']
    ];
}
