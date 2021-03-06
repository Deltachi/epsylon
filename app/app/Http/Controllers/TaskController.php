<?php

namespace App\Http\Controllers;

use App\Task;
use http\Env\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
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
        //$task = Task::find($id);
        $task = Task::where('type',$id)->first();
        if($task){
            //Wandel JSON-String in JSON-Objekt um, falls Wert != null
            $task['solution'] = $task['solution'] ? json_decode($task['solution']): null;
            $task['data'] = $task['data'] ? json_decode($task['data']): null;
            $task_json = json_encode($task, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
        }
        $component = "task".$id;
        return view('task.show', ['task_id' => $id, 'task_data' => $task_json, 'component' => $component]);
    }
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('task.index');
    }

    public function destroy(Request $request){
        $task_id = $request->task;
        DB::table('tasks')->where('id',$task_id)->delete();
        return response()->json(['method' => 'delete', 'success'=>true,'message'=>'Daten gelöscht!', 'messageType'=>'success'],200);
    }


}
