<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;

class BBSBoard extends Model
{
    protected $table = 'bbs_boards';

    public function toArray()
    {
        return [
            '_id' => strval($this->id),
            'id' => strval($this->id),
            'name' => $this->name,
            'description' => $this->description,
            'picture' => $this->picture
        ];
    }
}
