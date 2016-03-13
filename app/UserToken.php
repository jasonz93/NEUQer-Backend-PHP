<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id', 'client', 'token'
    ];

    public function user() {
        return $this->belongsTo('NEUQer\User');
    }

    public static function createByUser(User $user, $client) {
        $token = UserToken::updateOrCreate([
            'user_id' => $user->id,
            'client' => $client
        ], [
            'token' => uniqid()
        ]);
        return $token;
    }
}
