<?php

namespace Tests\Unit;

use App\Tasks;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TasksTest extends TestCase
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

    public function testListTasks()
    {
        $tasks = new Tasks();
        $result = response()->json($tasks->list('neerajkanuri','todo monthly')[0]);
        $this->assertSame(json_encode([
            'tasks' => ["charge the phone","generate an application"]
        ]), $result->getContent());
    }

    public function testAddTask()
    {
        $tasks = new Tasks();
        $result = response()->json($tasks->add('testing4','sample1','hello task')[0]);
        $this->assertSame(json_encode([
            'Response' => "The task hello task has been added to the list sample1 belonging to testing4"
        ]), $result->getContent());
    }

    public function testAddTaskExists()
    {
        $tasks = new Tasks();
        $result = response()->json($tasks->add('testing4','sample1','hello task')[0]);
        $this->assertSame(json_encode([
            'Error' => "The task hello task already exists in the list sample1 belonging to testing4"
        ]), $result->getContent());
    }

    public function testUpdateTask()
    {
        $tasks = new Tasks();
        $result = response()->json($tasks->change('testing4','sample1','hello task','new task')[0]);
        $this->assertSame(json_encode([
            'Response' => "The task hello task has been updated to new task in the list sample1 belonging to testing4"
        ]), $result->getContent());
    }

    public function testUpdateTaskDoesNotExist()
    {
        $tasks = new Tasks();
        $result = response()->json($tasks->change('testing4','sample1','hello task','new task')[0]);
        $this->assertSame(json_encode([
            'Error' => "The task hello task does not exist in the list sample1 belonging to testing4"
        ]), $result->getContent());
    }

    public function testDeleteTask()
    {
        $tasks = new Tasks();
        $result = response()->json($tasks->remove('testing4','sample1','new task')[0]);
        $this->assertSame(json_encode([[
            'description' => 'new task',
        ]]), $result->getContent());
    }

    public function testDeleteTaskDoesNotExist()
    {
        $tasks = new Tasks();
        $result = response()->json($tasks->remove('testing4','sample1','new task')[0]);
        $this->assertSame(json_encode([
            'Error' => 'The task new task does not exist in the list sample1 belonging to testing4',
        ]), $result->getContent());
    }


}
