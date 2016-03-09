<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustRoleTrait;

class Role extends Model
{
    use EntrustRoleTrait;
}
