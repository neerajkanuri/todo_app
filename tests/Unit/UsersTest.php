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

    public static $testData = [
        'testAddUser' => [
            'response' => [
                'status' => 'User exists',
                // Guzzle library
            ]
        ],
    ];

    public function testAddUser()
    {
        $users = new Users();

        $result = response()->json($users->addUser('neeraj','abcd'));

        $expectedResponse = $this->getExpectedResponse();

        $this->assertSame(json_encode($expectedResponse, $result->getContent());
    }

    public function getExpectedResponse()
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);

        $functionName = $trace[1]['function'];

        return self::$testData[$functionName]['response'];
    }
}