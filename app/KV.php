<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;

class KV extends Model
{
    protected $table = 'kvs';
    protected $primaryKey = 'key';
    protected $fillable = [
        'key',
        'value'
    ];
}
