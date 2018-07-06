<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    //
//    protected $fillable = ['name','user_id'];

    public function users()
    {
        return $this->belongsTo(Users::class);
    }

    public function tasks()
    {
        return $this->hasMany(Tasks::class);
    }
}
