<?php

namespace App\Http\Controllers;

use App\Subject;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamCorrectorController extends Controller
{
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

    public function index($subject_id){
        $user = User::find(Auth::user()->id);
        $subject = Subject::find($subject_id);
        $answer_table = [];
        foreach ($subject->exams as $exam) {
            $answer_table[] = DB::table('answers')->where('exam_id',$exam->id)->get();
        }

        return view('exam_corrector.index',['user'=>$user,'exams'=>$this->findAndSetActiveExams($subject->exams), 'subject'=>$subject]);
    }
}
