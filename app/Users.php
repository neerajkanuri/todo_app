<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
            return [['Error' => "User with username: $username exists"],409];
        }

        else{
            Users::create(['username' => $username, 'name' => $name]);
            return [['Response' => "User username: $username name: $name has been created"],200];
        }
    }

    public function remove($username)
    {
        if (Users::where('username', '=', $username)->exists()) {
            $deleteduser = Users::select('name','username')->where('username','=',$username)->get();
            Users::where('username', '=', $username)->delete();
            return [$deleteduser,200];
        }

        else{
            return [['Error' => "Username does not exist"],404];
        }
    }

    public function list()
    {
        $users = Users::select('name')->pluck('name');

        if(sizeof($users) > 0) {
            return [['names' => $users],200];
        }

        else {
            return [['Error' => 'No users found in the database'],404];
        }

    }

    public function getId($username)
    {
        if (Users::where('username', '=', $username)->exists())
        {
            $userid = Users::select('id')->where('username','=',$username)->pluck('id')[0];
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
                return [['Error' => "Username $username has not been updated to $newusername since $newusername already exists"],409];
            }
            else{
                Users::where('username', '=', $username)
                    ->update(['username' => $newusername]);
                return [['Response' => "Username $username has been updated to $newusername"],200];
            }

        }

        else{
            return [['Error' => "User with username $username does not exist"],404];
        }
    }
}