<?php

namespace App\Http\Controllers;

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
        return view('task', ['task_id' => $id]);
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
