<?php namespace SunLab\LevelUp\Models;

use Winter\Storm\Database\Model;

/**
 * ExperienceIncreaser Model
 */
class ExperienceIncreaser extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'sunlab_levelup_experience_increasers';

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
        'measure_name' => 'required',
        'points' => 'required'
    ];

    public $timestamps = false;
}
