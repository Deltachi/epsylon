<?php

namespace App\Http\Controllers;

use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $role = $user->role;
        if ($role == 'student'){
            return redirect()->route('exam.index');
        }
        return view('home', ['user'=>$user]);
    }

    public function action(Request $request){
        if ($request->action_exam_create){
            echo "Erstelle Klausur für ". Subject::find($request->subject)->name;
        } elseif ($request->action_exam_edit){
            return redirect()->route('exam.edit.index',[$request->subject]);
        } elseif ($request->action_exam_activate){
            return redirect()->route('exam.edit.index',[$request->subject]);
        } elseif ($request->action_exam_correct){
            return redirect()->route('exam.correct.index',[$request->subject]);
        }
    }


}
