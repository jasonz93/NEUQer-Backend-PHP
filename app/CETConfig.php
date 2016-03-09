<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;

class CETConfig extends Model
{
    protected $table = 'cet_configs';
    protected $primaryKey = 'mp_id';

    public function mp() {
        return $this->belongsTo('NEUQer\Wx3rdMP');
    }
}
