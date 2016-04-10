<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;

/**
 * NEUQer\SigninLesson
 *
 * @property integer $id
 * @property integer $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\SigninLesson whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\SigninLesson whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\SigninLesson whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\SigninLesson whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SigninLesson extends Model
{
    protected $table = 'signin_lesson';

    protected $primaryKey = 'id';
}
