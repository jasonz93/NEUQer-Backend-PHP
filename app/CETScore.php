<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;

class CETScore extends Model
{
    protected $table = 'cet_scores';

    public function admission() {
        return $this->belongsTo('NEUQer\CETAdmission');
    }
}
