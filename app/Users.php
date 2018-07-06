<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    //
    const NAME = 'name';
    protected $table = 'users';
    protected $fillable = ['name','username'];

    public function lists()
    {
        return $this->hasMany(Lists::class);
    }

    public function addUser($name, $username)
    {
        echo $name;
        echo $username;
//        $user = Users::firstOrCreate(
//        // Query only by foursquare_id
//            ['username' => $username],
//            // But, if ends up creating a Bar, also add this parameters
//            [
//                'name'       => $name,
//            ]
//        );
        if (Users::where('username', '=', $username)->exists()) {
            return ['status' => "User exists"];
        }
        else{
            return ['status' => "User has to be created"];
        }

//        echo $user;
    }

}