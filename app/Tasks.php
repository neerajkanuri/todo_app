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
            return [['Error' => "Username $username does not exist"],404];
        }
        if($listid == -2)
        {
            return [['Error' => "Username $username does not have the list $listname"],404];
        }

        if (Tasks::where('list_id', '=', $listid)->where('description','=',$description)->exists()) {
            return [['Error' => "The task $description already exists in the list $listname belonging to $username"],409];
        }
        else{
            Tasks::create(['description' => $description, 'list_id'=>$listid]);
            return [['Response' => "The task $description has been added to the list $listname belonging to $username"],200];
        }

    }

    public function remove($username, $listname, $description)
    {
        $lists = new Lists;
        $listid = $lists->getId($username,$listname);
        if($listid == -1)
        {
            return [['Error' => "Username $username does not exist"],404];
        }
        if($listid == -2)
        {
            return [['Error' => "Username $username does not have the list $listname"],404];
        }

        if (Tasks::where('list_id', '=', $listid)->where('description','=',$description)->exists()) {
            $deletedtask = Tasks::where('list_id', '=', $listid)->where('description','=',$description)->select('description')->get();
            Tasks::where('list_id', '=', $listid)->where('description','=',$description)->delete();
            return [$deletedtask,200];
        }
        else{
            return [['Error' => "The task $description does not exist in the list $listname belonging to $username"],404];
        }

    }

    public function list($username, $listname)
    {
        $lists = new Lists;
        $listid = $lists->getId($username,$listname);
        if($listid == -1)
        {
            return [['Error' => "Username $username does not exist"],404];
        }
        if($listid == -2)
        {
            return [['Error' => "Username $username does not have the list $listname"],404];
        }

        $tasks = Tasks::select('description')->where('list_id','=',$listid)->pluck('description');
        if(sizeof($tasks)>0){
            return [['tasks' => $tasks],200];
        }
        
        else{
            return [['Error' => 'No tasks found for '.$listname.' of '.$username],404];
        }
    }

    public function change($username, $listname, $description, $newdescription)
    {
        $lists = new Lists;
        $listid = $lists->getId($username,$listname);

        if($listid == -1) {
            return [['Error' => "Username $username does not exist"],404];
        }

        if($listid == -2) {
            return [['Error' => "Username $username does not have the list $listname"],404];
        }

        if (Tasks::where('list_id', '=', $listid)->where('description','=',$description)->exists()) {

            if (Tasks::where('list_id', '=', $listid)->where('description','=',$newdescription)->exists()) {
                return [['Error' => "The task $description has not been updated to $newdescription in the list $listname belonging to $username since the task $newdescription in the list $listname belonging to $username already exists"],409];
            }

            else {
                Tasks::where('list_id', '=', $listid)
                    ->where('description', '=', $description)
                    ->update(['description' => $newdescription]);
                return [['Response' => "The task $description has been updated to $newdescription in the list $listname belonging to $username"],200];
            }

        }

        else{
            return [['Error' => "The task $description does not exist in the list $listname belonging to $username"],404];
        }

    }

}
