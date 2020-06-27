<?php

namespace App\Http\Controllers;

use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
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

    public function index(){
        $user = User::find(Auth::user()->id);
        $exams = $user->exams;
        if(isset($exams)){
            $now = new DateTime("now");
            foreach ($exams as $exam){
                if(isset($exam->begin, $exam->end) && $exam->status === "pending" && $exam->final == true){
                    try {
                        $exam->begin = new DateTime($exam->begin);
                        $exam->end = new DateTime($exam->end);
                        if ($now > $exam->begin && $now < $exam->end){
                            $exam->status = "open";
                        }elseif ($now > $exam->end){
                            $exam->status = "closed";
                        }
                    } catch (\Exception $e) {
                    }
                }
            }
        }
        //dd($exams);

        return view('exam.index', ['user'=> $user, 'exams'=>$exams]);
    }

    public function show($exam_id){

        return view('exam.show');
    }
}
