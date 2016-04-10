<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;

/**
 * NEUQer\StuInfo
 *
 * @property integer $id
 * @property string $stu_id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\StuInfo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\StuInfo whereStuId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\StuInfo whereName($value)
 * @mixin \Eloquent
 * @property integer $user_id
 * @property integer $weixin_user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \NEUQer\User $user
 * @property-read \NEUQer\WeixinUser $weixinUser
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\SigninAdmission whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\SigninAdmission whereWeixinUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\SigninAdmission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\SigninAdmission whereUpdatedAt($value)
 */
class SigninAdmission extends Model
{
    protected $table = 'signin_admission';

    protected $primaryKey = 'id';

    public function user(){
        return $this->belongsTo('NEUQer\User');
    }

    public function weixinUser(){
        return $this->belongsTo('NEUQer\WeixinUser');
    }
}
