<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;

class BBSLike extends Model
{
    protected $table = 'bbs_likes';

    public function user() {
        return $this->belongsTo('NEUQer\User');
    }

    public function likeable() {
        return $this->morphTo();
    }
}
