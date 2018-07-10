<?php

namespace Tests\Unit;

use App\Users;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public static $testData = [];

    public function testListUsers()
    {
        $users = new Users();
        $result = response()->json($users->list()[0]);
        $this->assertSame(json_encode([
            'names' => ["User 1","User 2","neeraj","neeraj","Neeraj","ABCD","KLJD","User 23","Neeraj","Donald Duck","Mickey Mouse","neeraj","neeraj"]
        ]), $result->getContent());
    }

    public function testAddUserExists()
    {
        $users = new Users();
        $result = response()->json($users->add('neeraj','abcd')[0]);
        $this->assertSame(json_encode([
            'Error' => 'User with username: '.'abcd'.' exists'
        ]), $result->getContent());
    }

    public function testAddUserNew()
    {
        $users = new Users();
        $result = response()->json($users->add('neeraj','testing1')[0]);
        $this->assertSame(json_encode([
            'Response' => 'User username: testing1 name: neeraj has been created'
        ]), $result->getContent());
    }

    public function testUpdateUserName()
    {
        $users = new Users();
        $result = response()->json($users->change('testing1','testing2')[0]);
        $this->assertSame(json_encode([
            'Response' => 'Username testing1 has been updated to testing2'
        ]), $result->getContent());
    }

    public function testUpdateUserNameDoesNotExist()
    {
        $users = new Users();
        $result = response()->json($users->change('testing1','testing2')[0]);
        $this->assertSame(json_encode([
            'Error' => 'User with username testing1 does not exist'
        ]), $result->getContent());
    }


    public function testDeleteUser()
    {
        $users = new Users();
        $result = response()->json($users->remove('testing2')[0]);
        $this->assertSame(json_encode([[
            "name" => "neeraj",
            "username" => "testing2"
        ]]),$result->getContent());
    }

    public function testDeleteUserDoesNotExist()
    {
        $users = new Users();
        $result = response()->json($users->remove('testing2')[0]);
        $this->assertSame(json_encode([
            "Error" => "Username does not exist",
        ]),$result->getContent());
    }

}