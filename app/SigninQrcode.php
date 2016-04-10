<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;

/**
 * NEUQer\SigninQrcode
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $uniqid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\SigninQrcode whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\SigninQrcode whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\SigninQrcode whereUniqid($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\SigninQrcode whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\SigninQrcode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SigninQrcode extends Model
{
    protected $table = 'signin_qrcode';

    protected $primaryKey = 'id';

    protected $fillable = ['uniqid','admission_id'];

    public function stuInfo(){
        return $this->belongsTo('NEUQer/StuInfo');
    }

    public function addSignin($aid, $uniqid){
        SigninQrcode::updateOrCreate([
            'admission_id' => $aid
        ],[
            'admission_id' => $aid,
            'uniqid' => $uniqid
        ]);
    }

    public function checkSignin($aid, $uniqid){
        $signin = SigninQrcode::where('admission_id',$aid)
            ->take(1)
            ->get();
        $signin = $signin[0];
        if($signin == null){
            return false;
        }
        if($signin->uniqid != $uniqid){
            return false;
        }
        $time = $signin->updated_at->getTimestamp();
        if(time() - $time > 15){
            return false;
        }
        return true;
    }
}
