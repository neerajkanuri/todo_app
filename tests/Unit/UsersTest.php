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
//    public function testExample()
//    {
//        $this->assertTrue(true);
//    }

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
        $check = $users->add('neeraj','abcd');
        $result = response()->json($check[0]);
        $this->assertSame(json_encode([
            'Error' => 'User with username: '.'abcd'.' exists'
        ]), $result->getContent());
        $this->assertSame($check[1], 409);
    }

    public function testAddUserNew()
    {
        $users = new Users();
        $check = $users->add('neeraj','testing1');
        $result = response()->json($check[0]);
        $this->assertSame(json_encode([
            'Response' => 'User username: testing1 name: neeraj has been created'
        ]), $result->getContent());
        $this->assertSame($check[1],200);
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
        $check = $users->change('testing1','testing2');
        $result = response()->json($check[0]);
        $this->assertSame(json_encode([
            'Error' => 'User with username testing1 does not exist'
        ]), $result->getContent());
        $this->assertSame($check[1],404);
    }


    public function testDeleteUser()
    {
        $users = new Users();
        $result = response()->json($users->remove('testing2')[0]);
        $this->assertSame(json_encode([
            'user deleted' => [["name" => "neeraj", "username" => "testing2",]],
        ]),$result->getContent());
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