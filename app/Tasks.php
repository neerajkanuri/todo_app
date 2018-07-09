<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tasks extends Model
{
    //
    protected $table = 'tasks';
    protected $fillable = ['description','list_id'];

    public function lists()
    {
        return $this->belongsTo(Lists::class);
    }

    public function add($username, $listname, $description)
    {
        $lists = new Lists;
        $listid = $lists->getId($username,$listname);
        if($listid == -1)
        {
            return ['status' => "Username $username does not exist"];
        }
        if($listid == -2)
        {
            return ['status' => "Username $username does not have the list $listname"];
        }

        if (Tasks::where('list_id', '=', $listid)->where('description','=',$description)->exists()) {
            return ['status' => "The task $description already exists in the list $listname belonging to $username"];
        }
        else{
            $list = Tasks::firstOrCreate(
                ['description' => $description],
                // But, if ends up creating a Bar, also add this parameters
                [
                    'list_id'       => $listid,
                ]
            );
            return ['status' => "The task $description has been added to the list $listname belonging to $username"];
        }

    }

    public function remove($username, $listname, $description)
    {
        $lists = new Lists;
        $listid = $lists->getId($username,$listname);
        if($listid == -1)
        {
            return ['status' => "Username $username does not exist"];
        }
        if($listid == -2)
        {
            return ['status' => "Username $username does not have the list $listname"];
        }

        if (Tasks::where('list_id', '=', $listid)->where('description','=',$description)->exists()) {
            Tasks::where('list_id', '=', $listid)->where('description','=',$description)->delete();
            return ['status' => "The task $description has been removed from the list $listname belonging to $username"];
        }
        else{
            return ['status' => "The task $description does not exist in the list $listname belonging to $username"];
        }

    }

    public function list($username, $listname)
    {
        $lists = new Lists;
        $listid = $lists->getId($username,$listname);
        if($listid == -1)
        {
            return ['status' => "Username $username does not exist"];
        }
        if($listid == -2)
        {
            return ['status' => "Username $username does not have the list $listname"];
        }

        $tasks = DB::table('tasks')->select('description')->where('list_id','=',$listid)->pluck('description');
        return $tasks;
    }

    public function change($username, $listname, $description, $newdescription)
    {
        $lists = new Lists;
        $listid = $lists->getId($username,$listname);

        if($listid == -1) {
            return ['status' => "Username $username does not exist"];
        }

        if($listid == -2) {
            return ['status' => "Username $username does not have the list $listname"];
        }

        if (Tasks::where('list_id', '=', $listid)->where('description','=',$description)->exists()) {

            if (Tasks::where('list_id', '=', $listid)->where('description','=',$newdescription)->exists()) {
                return ['status' => "The task $description has not been updated to $newdescription in the list $listname belonging to $username since the task $newdescription in the list $listname belonging to $username already exists"];
            }

            else {
                DB::table('tasks')
                    ->where('list_id', '=', $listid)
                    ->where('description', '=', $description)
                    ->update(['description' => $newdescription]);
                return ['status' => "The task $description has been updated to $newdescription in the list $listname belonging to $username"];
            }

        }

        else{
            return ['status' => "The task $description does not exist in the list $listname belonging to $username"];
        }

    }

}
