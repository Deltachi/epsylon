<?php

namespace App\Http\Controllers;

use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
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

    public function store(Request $request){
        $user = User::find(Auth::user()->id);
        $validatedData = $request->validate([
            'name' => 'required|unique:subjects|max:255'
        ]);
        $subject = new Subject;
        $subject->name = $request->name;
        $subject->save();
        $user->subjects()->attach($subject->id);
        $user->save();
        return redirect()->back();
    }
}
