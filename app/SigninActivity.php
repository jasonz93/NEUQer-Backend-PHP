<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;

/**
 * NEUQer\SigninActivity
 *
 * @mixin \Eloquent
 */
class SigninActivity extends Model
{
    protected $table = 'signin_activity';

    protected $primaryKey = 'id';

    public function device(){
        return $this->hasOne('NEUQer/SigninDevice');
    }

    public function lesson(){
        return $this->hasOne('NEUQer/SigninLesson');
    }
}
