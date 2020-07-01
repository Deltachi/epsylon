<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Exam;
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

    public function findAndSetActiveExams($exams){
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
        return $exams;
    }

    public function getAllUserExams(){
        $user = User::find(Auth::user()->id);
        $exams = $user->exams;
        if(isset($exams)){
            $exams = $this->findAndSetActiveExams($exams);
        }
        return $exams;
    }

    public function getOpenUserExams(){
        $exams =$this->getAllUserExams();
        foreach($exams as $id => $exam){
            if ($exam->status !== "open"){
                $exams->forget($id);
            }
        }
        return $exams;
    }

    public function index(){
        $user = User::find(Auth::user()->id);
        $exams = $this->getAllUserExams();

        return view('exam.index', ['user'=> $user, 'exams'=>$exams]);
    }

    public function show($exam_id){
        $user = User::find(Auth::user()->id);
        $exam = Exam::find($exam_id);
        $exams = $this->getOpenUserExams();
        if($exams->contains($exam)){
            $user->exams()->updateExistingPivot($exam, array('state' => 'dirty'), false);
            foreach($exam->tasks as $task){
                if($task){
                    //Wandel JSON-String in JSON-Objekt um, falls Wert != null
                    $task['solution'] = $task['solution'] ? json_decode($task['solution']): null;
                    $task['data'] = $task['data'] ? json_decode($task['data']): null;

                    $answer = Answer::where('user_id',$user->id)->where('exam_id',$exam->id)->where('task_id',$task->id)->first();
                    $task['answered'] = isset($answer);
                    //$tasks[] = $task;
                    //$tasks_json_array[] = json_encode($task, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
                }
            }

            return view('exam.show',['user'=>$user,'exam'=>$exam]);
        }
        return redirect()->route('exam.index');
    }
}
