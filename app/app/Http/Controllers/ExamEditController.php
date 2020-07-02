<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Subject;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamEditController extends Controller
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
            if(isset($exam->begin, $exam->end)){
                try {
                    $exam->begin = new DateTime($exam->begin);
                    $exam->end = new DateTime($exam->end);
                } catch (\Exception $e) {
                }
                if(($exam->status === "pending" ||  $exam->status === "open" )){
                    if ($now > $exam->begin && $now < $exam->end){
                        $exam->status = "open";
                    }elseif ($now > $exam->end){
                        $exam->status = "closed";
                    }
                }
            }
        }
        return $exams;
    }

    public function index($subjectId){
        $user = User::find(Auth::user()->id);
        $subject = Subject::find($subjectId);
        $exams = $subject->exams;
        $exams = $this->findAndSetActiveExams($exams);
        return view('exam_editor.index',['subject'=>$subject,'exams'=>$exams, 'user'=>$user]);
    }

    public function updateStatus(Request $request){
        $exam = Exam::find($request->examId);
        $exam->status = $request->status;
        $exam->save();
        return redirect()->back();
    }
}
