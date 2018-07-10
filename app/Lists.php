<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
            return [['Error' => "Username $username does not exist"],404];
        }

        if (Lists::where('user_id', '=', $userid)->where('name','=',$listname)->exists()) {
            return [['Error' => "List $listname belonging to $username exists"],409];
        }
        else{
            Lists::create(['name' => $listname, 'user_id' => $userid]);
            return [['Response' => "List $listname belonging to $username has been created"],200];
        }

    }

    public function remove($username,$listname)
    {
        $users = new Users;
        $userid = $users->getId($username);

        if($userid == -1)
        {
            return [['Error' => "Username $username does not exist"],404];
        }

        if (Lists::where('user_id', '=', $userid)->where('name','=',$listname)->exists()) {
            $deletedlist = Lists::where('user_id', '=', $userid)->where('name','=',$listname)->select('name')->get();
            Lists::where('user_id', '=', $userid)->where('name','=',$listname)->delete();
            return [$deletedlist,200];
        }
        else{
            return [['Error' => "List $listname belonging to $username does not exist"],404];
        }

    }

    public function show($username)
    {
        $users = new Users;
        $userid = $users->getId($username);

        if($userid == -1)
        {
            return [['Error' => "Username $username does not exist"],404];
        }

        $lists = Lists::select('name')->where('user_id','=',$userid)->pluck('name');
        if(sizeof($lists) > 0) {
        return [['lists' => $lists],200];
        }
        else{
            return [['Error' => 'No lists found for '.$username],404];
        }
    }

    public function getId($username, $listname)
    {
        $users = new Users;
        $userid = $users->getId($username);

        if ($userid == -1) {
            return -1;
        }

        if (Lists::where('user_id', '=', $userid)->where('name', '=', $listname)->exists()) {

            $listid = Lists::select('id')->where('user_id', '=', $userid)->where('name', '=', $listname)->pluck('id')[0];
            // echo "This is what is happening";
            return $listid;
        }
        else{
            // echo "This is what is not happending";
            return -2;
        }
    }

    public function change($username,$listname, $newlistname)
    {
        $users = new Users;
        $userid = $users->getId($username);

        if($userid == -1) {
            return [['Error' => "Username $username does not exist"],404];
        }

        if (Lists::where('user_id', '=', $userid)->where('name','=',$listname)->exists()) {
            if (Lists::where('user_id', '=', $userid)->where('name', '=', $newlistname)->exists()) {
                return [['Error' => "List $listname belonging to $username has not been updated to the new name $newlistname since there is already a list with $newlistname belonging to $username "],409];
            }
            else {
                Lists::where('user_id', '=', $userid)
                    ->where('name', '=', $listname)
                    ->update(['name' => $newlistname]);
                return [['Response' => "List $listname belonging to $username has been updated to the new name $newlistname"],200];
            }
        }
        else{
            return [['Error' => "List $listname belonging to $username does not exist"],404];
        }

    }
}
