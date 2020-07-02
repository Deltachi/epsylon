<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Exam;
use App\Subject;
use App\Task;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\task;

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

    public function newExam($subjectId){
        $subject = Subject::find($subjectId);
        if ($subject){
            $exam = new Exam;
            $exam->subject_id = $subjectId;
            $exam->save();
            return redirect()->route('exam.edit',$exam->id);
        }
        return response()->isInvalid();
    }
    public function editExam($examId){
        $exam = Exam::find($examId);
        foreach($exam->tasks as $task){
            if($task){
                //Wandel JSON-String in JSON-Objekt um, falls Wert != null
                $task['data'] = $task['data'] ? json_decode($task['data']): null;
            }
        }
        return view('exam_editor.show',['exam' => $exam]);
    }
    public function saveExam(Request $request){
        $exam_id = $request->exam;
        $exam = $request->data;
        DB::table('exams')->where('id',$exam['id'])->update([
            'subject_id' => $exam['subject_id'],
            'title' => $exam['title'],
            'final' => $exam['final'],
            'begin' => $exam['begin'],
            'end' => $exam['end'],
            'reenter' => $exam['reenter'],
            'terms' => $exam['terms'],
        ]);
        foreach($exam['tasks'] as $task){
            if (isset($task['id'])){
                DB::table('tasks')->where('id',$task['id'])->update([
                    'type' => $task['type'],
                    'title' => $task['title'],
                    'description' => $task['description'],
                    'hint' => $task['hint'],
                    'solution' => $task['solution'],
                    'data' => $task['data'],
                    'points' => $task['points'],
                ]);
            }else{
                $new_task = new Task;
                $new_task->type = $task['type'];
                if (isset($task['title'])){
                    $new_task->title = $task['title'];
                }
                if (isset($task['description'])) {
                    $new_task->description = $task['description'];
                }
                if (isset($task['hint'])) {
                    $new_task->hint = $task['hint'];
                }
                if (isset($task['solution'])) {
                    $new_task->solution = $task['solution'];
                }
                if (isset($task['data'])) {
                    $new_task->data = $task['data'];
                }
                if (isset($task['points'])) {
                    $new_task->points = $task['points'];
                }
                $new_task->save();
                $this_exam = Exam::find($exam['id']);
                $this_exam->tasks()->attach($new_task->id);
                $this_exam->save();
            }
        }
        return response()->json(['method' => 'post', 'success'=>true,'message'=>'Daten gespeichert!', 'messageType'=>'success'],200);
    }
    public function destroy(Request $request){
        $task_id = $request->task;
        DB::table('tasks')->where('id',$task_id)->delete();
        return response()->json(['method' => 'delete', 'success'=>true,'message'=>'Daten gelöscht!', 'messageType'=>'success'],200);
    }
}
