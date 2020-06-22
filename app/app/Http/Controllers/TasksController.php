<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //kein login, zum testen
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param $id
     * @return Renderable
     */
    public function show($id)
    {
        $task = Task::where('id', $id)->first();
        if($task && $task['solution']){
            $task['solution'] = json_decode($task['solution']);
        }
        $task_json = json_encode($task);
        return view('task', ['task_id' => $id, 'task_data' => $task_json]);
    }
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('tasks');
    }
}
