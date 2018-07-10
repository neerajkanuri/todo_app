<?php

namespace Tests\Unit;

use App\Lists;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListsTest extends TestCase
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

    public function testshowLists()
    {
        $lists = new Lists();
        $result = response()->json($lists->show('neerajkanuri')[0]);
        $this->assertSame(json_encode([
            'lists' => ["todo weekly","todo monthly"]
        ]), $result->getContent());
    }

    public function testAddList()
    {
        $lists = new Lists();
        $result = response()->json($lists->add('testing3','testing3list1')[0]);
        $this->assertSame(json_encode([
            'Response' => 'List testing3list1 belonging to testing3 has been created'
        ]), $result->getContent());
    }

    public function testAddListExists()
    {
        $lists = new Lists();
        $result = response()->json($lists->add('testing3','testing3list1')[0]);
        $this->assertSame(json_encode([
            'Error' => 'List testing3list1 belonging to testing3 exists'
        ]), $result->getContent());
    }

    public function testUpdateListName()
    {
        $lists = new Lists();
        $result = response()->json($lists->change('testing3','testing3list1','testing3list2')[0]);
        $this->assertSame(json_encode([
            'Response' => 'List testing3list1 belonging to testing3 has been updated to the new name testing3list2'
        ]), $result->getContent());
    }

    public function testUpdateListNameDoesNotExist()
    {
        $lists = new Lists();
        $result = response()->json($lists->change('testing3','testing3list1','testing3list2')[0]);
        $this->assertSame(json_encode([
            'Error' => 'List testing3list1 belonging to testing3 does not exist'
        ]), $result->getContent());
    }

    public function testDeleteList()
    {
        $lists = new Lists();
        $result = response()->json($lists->remove('testing3','testing3list2')[0]);
        $this->assertSame(json_encode([
            'list deleted' => [['name' => 'testing3list2',]],
            'username' => 'testing3',
        ]), $result->getContent());
    }

    public function testDeleteListDoesNotExist()
    {
        $lists = new Lists();
        $result = response()->json($lists->remove('testing3','testing3list2')[0]);
        $this->assertSame(json_encode([
            'Error' => 'List testing3list2 belonging to testing3 does not exist',
        ]), $result->getContent());
    }

}
