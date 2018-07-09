<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lists extends Model
{
    //
    protected $table = 'lists';
    protected $fillable = ['name','user_id'];

    public function users()
    {
        return $this->belongsTo(Users::class);
    }

    public function tasks()
    {
        return $this->hasMany(Tasks::class);
    }

    public function add($username, $listname)
    {
        $users = new Users;
        $userid = $users->getId($username);

        if($userid == -1)
        {
            return ['status' => "Username $username does not exist"];
        }

        if (Lists::where('user_id', '=', $userid)->where('name','=',$listname)->exists()) {
            return ['status' => "List $listname belonging to $username exists"];
        }
        else{
            $list = Lists::firstOrCreate(
                ['name' => $listname],
                // But, if ends up creating a Bar, also add this parameters
                [
                    'user_id'       => $userid,
                ]
            );
            return ['status' => "List $listname belonging to $username has been created"];
        }

    }

    public function remove($username,$listname)
    {
        $users = new Users;
        $userid = $users->getId($username);

        if($userid == -1)
        {
            return ['status' => "Username $username does not exist"];
        }

        if (Lists::where('user_id', '=', $userid)->where('name','=',$listname)->exists()) {
            Lists::where('user_id', '=', $userid)->where('name','=',$listname)->delete();
            return ['status' => "List $listname belonging to $username has been deleted"];
        }
        else{
            return ['status' => "List $listname belonging to $username does not exist"];
        }

    }

    public function show($username)
    {
        $users = new Users;
        $userid = $users->getId($username);

        if($userid == -1)
        {
            return ['status' => "Username $username does not exist"];
        }

        $lists = DB::table('lists')->select('name')->where('user_id','=',$userid)->pluck('name');
        return $lists;
    }

    public function getId($username, $listname)
    {
        $users = new Users;
        $userid = $users->getId($username);

        if ($userid == -1) {
            return -1;
        }

        if (Lists::where('user_id', '=', $userid)->where('name', '=', $listname)->exists()) {

            $listid = DB::table('lists')->select('id')->where('user_id', '=', $userid)->where('name', '=', $listname)->pluck('id')[0];
            echo "This is what is happening";
            return $listid;
        }
        else{
            echo "This is what is not happending";
            return -2;
        }
    }

    public function change($username,$listname, $newlistname)
    {
        $users = new Users;
        $userid = $users->getId($username);

        if($userid == -1) {
            return ['status' => "Username $username does not exist"];
        }

        if (Lists::where('user_id', '=', $userid)->where('name','=',$listname)->exists()) {
            if (Lists::where('user_id', '=', $userid)->where('name', '=', $newlistname)->exists()) {
                return ['status' => "List $listname belonging to $username has not been updated to the new name $newlistname since there is already a list with $listname belonging to $username "];
            }
            else {
                DB::table('lists')
                    ->where('user_id', '=', $userid)
                    ->where('name', '=', $listname)
                    ->update(['name' => $newlistname]);
                return ['status' => "List $listname belonging to $username has been updated to the new name $newlistname"];
            }
        }
        else{
            return ['status' => "List $listname belonging to $username does not exist"];
        }

    }
}
