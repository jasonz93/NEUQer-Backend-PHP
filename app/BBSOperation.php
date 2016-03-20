<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;

class BBSOperation extends Model
{
    protected $table = 'bbs_operations';

    public function entity() {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo('NEUQer\User');
    }
}
