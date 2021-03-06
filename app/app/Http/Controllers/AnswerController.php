<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnswerController extends Controller
{
    public function __construct()
    {
        //ohne login kein Zugriff
        //$this->middleware('auth');
    }

    public function verifyAccess(int $user_id){
        $auth_user = Auth()->user();
        if(!isset($auth_user)){return false;}
        $auth_user_id = $auth_user->id;
        if($auth_user_id !== $user_id){
            return false;
        }
        return true;
    }
    public function notAuthorizedResponse(){
        return response()->json(['success'=>false,'message'=>'Nicht autorisierter Zugriff!', 'messageType'=>'danger'],200);
    }

    /**
     * Liefert die JSON Daten der Antwort mit dem angegebenen (user_id,task_id,exam_id) Schlüssel zurück
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $user_id, int $exam_id, int $task_id){
        if( !$this->verifyAccess($user_id) ){ return $this->notAuthorizedResponse(); }

        $answer = Answer::where('user_id',$user_id)->where('exam_id',$exam_id)->where('task_id',$task_id)->first();
        if (isset($answer)){
            return response()->json(['method' => 'get','success'=>true,'message'=>'Daten geladen!', 'data'=>$answer->data, 'messageType'=>'success'],200);
        }
        return response()->json(['method' => 'get','success'=>false,'message'=>'Bitte beantworte diese Frage', 'messageType'=>'info'],200);
    }

    /**
     * Fügt die Antwort mit dem angegebenen (user_id,task_id,exam_id) Schlüssel in die DB ein, oder überschreibt diese
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $user_id = $request->user;
        $exam_id = $request->exam;
        $task_id = $request->task;
        $data = $request->data;

        if( !$this->verifyAccess($user_id) ){ return $this->notAuthorizedResponse(); }

        if(isset($user_id, $exam_id, $task_id)){
            if(isset($data) && !empty($data)){
                $old_answer = Answer::where('user_id',$user_id)->where('exam_id',$exam_id)->where('task_id',$task_id)->first();
                if(isset($old_answer)){
                    DB::table('answers')->where('user_id',$user_id)->where('exam_id',$exam_id)->where('task_id',$task_id)->update(['data' => json_encode($data)]);
                    return response()->json(['method' => 'post','success'=>true,'message'=>'Daten aktualisiert!', 'messageType'=>'success'],200);
                }else{
                    $answer = new Answer;
                    $answer->user_id = $user_id;
                    $answer->exam_id = $exam_id;
                    $answer->task_id = $task_id;
                    $answer->data = json_encode($data);
                    $answer->save();
                    return response()->json(['method' => 'post','success'=>true,'message'=>'Neue Daten gespeichert!', 'messageType'=>'success'],200);
                }
            }
            return response()->json(['method' => 'post','success'=>false,'message'=>'Keine Eingabe', 'messageType'=>'warning'],200);
        }
        return response()->json(['method' => 'post','success'=>false,'message'=>'Daten können nicht gespeichert werden!', 'messageType'=>'danger'],200);
    }

    /**
     * Löscht die Antwort mit dem angegebenen (user_id,task_id,exam_id) Schlüssel
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request){
        $user_id = $request->user;
        $exam_id = $request->exam;
        $task_id = $request->task;

        if( !$this->verifyAccess($user_id) ){ return $this->notAuthorizedResponse(); }

        DB::table('answers')->where('user_id',$user_id)->where('exam_id',$exam_id)->where('task_id',$task_id)->delete();
        return response()->json(['method' => 'delete', 'success'=>true,'message'=>'Daten gelöscht!', 'messageType'=>'success'],200);
    }
}
