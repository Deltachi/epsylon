<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnswersController extends Controller
{
    /**
     * Liefert die JSON Daten der Antwort mit dem angegebenen (user_id,task_id,exam_id) Schlüssel zurück
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id){
        $answer = Answer::find($id);
        if (isset($answer)){
            return response()->json(['success'=>true,'message'=>'Daten geladen!', 'data'=>$answer->data],200);
        }
        return response()->json(['success'=>false,'message'=>'Antwort nicht gefunden'],200);
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
        if(isset($user_id, $exam_id, $task_id)){
            if(isset($data)){
                $old_answer = Answer::where('user_id',$user_id)->where('exam_id',$exam_id)->where('task_id',$task_id)->first();
                if(isset($old_answer)){
                    DB::table('answers')->where('user_id',$user_id)->where('exam_id',$exam_id)->where('task_id',$task_id)->update(['data' => json_encode($data)]);
                    return response()->json(['success'=>true,'message'=>'Daten aktualisiert!'],200);
                }else{
                    $answer = new Answer;
                    $answer->user_id = $user_id;
                    $answer->exam_id = $exam_id;
                    $answer->task_id = $task_id;
                    $answer->data = json_encode($data);
                    $answer->save();
                    return response()->json(['success'=>true,'message'=>'Neue Daten gespeichert!'],200);
                }
            }
            return response()->json(['success'=>false,'message'=>'Es sind keine Daten zum Speichern vorhanden!'],200);
        }
        return response()->json(['success'=>false,'message'=>'Daten können nicht gespeichert werden!'],200);
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
        DB::table('answers')->where('user_id',$user_id)->where('exam_id',$exam_id)->where('task_id',$task_id)->delete();
        return response()->json(['success'=>true,'message'=>'Daten gelöscht!'],200);
    }
}
