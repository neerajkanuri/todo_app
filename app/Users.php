<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    //
    protected $table = 'users';
    protected $fillable = ['name','username'];

    public function lists()
    {
        return $this->hasMany(Lists::class);
    }

    public function add($name, $username)
    {
        if (Users::where('username', '=', $username)->exists()) {
            return ['status' => "User exists"];
        }

        else{
            $user = Users::firstOrCreate(
            ['username' => $username],
            // But, if ends up creating a Bar, also add this parameters
            [
                'name'       => $name,
            ]
        );
            return ['status' => "User has been created"];
        }
    }

    public function remove($username)
    {
        if (Users::where('username', '=', $username)->exists()) {
            Users::where('username', '=', $username)->delete();
            return ['status' => "User has been deleted"];
        }

        else{
            return ['status' => "Username does not exist"];
        }
    }

    public function list()
    {
        $users = DB::table('users')->select('name','username')->get();

        return $users;
    }

    public function getId($username)
    {
        if (Users::where('username', '=', $username)->exists())
        {
            $userid = DB::table('users')->select('id')->where('username','=',$username)->pluck('id')[0];
            return $userid;
        }

        else{
            return -1;
        }
    }

    public function change($username, $newusername)
    {
        if (Users::where('username', '=', $username)->exists()) {
            if (Users::where('username', '=', $newusername)->exists()) {
                return ['status' => "Username $username has not been updated to $newusername since $newusername already exists"];
            }
            else{
                DB::table('users')
                    ->where('username', '=', $username)
                    ->update(['username' => $newusername]);
                return ['status' => "Username $username has been updated to $newusername"];
            }

        }

        else{
            return ['status' => "User with username $username does not exist"];
        }
    }
}