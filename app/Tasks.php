<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    //
//    protected $fillable = ['description','list_id'];

    public function lists()
    {
        return $this->belongsTo(Lists::class);
    }
}
