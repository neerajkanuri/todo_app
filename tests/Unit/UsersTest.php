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

    public function testAddUser()
    {
        $users = new Users();
        $result = response()->json($users->addUser('neeraj','abcd'));
        $this->assertSame(json_encode([
            'status' => 'User exists'
        ]), $result->getContent());
    }
}