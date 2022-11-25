<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use  Barryvdh\DomPDF\Facade\Pdf;

class TaskController extends Controller
{
   public function login(){

        return view('auth.login');
   }


   public function task(){
    $search = Request('search');
    if(isset($search)){
        $tasks = Task::where('name','like','%'.$search.'%')
                    ->where('user_id','=',auth()->user()->id)->paginate(5);
    }else{
        $tasks = Task::where('user_id','=',auth()->user()->id)->paginate(5);
    }
    
    return view('pages.tasks',[
        'tasks'=>$tasks
    ]);
   }
   public function addTask(){
    return view('pages.addtask');
   }

   public function save(TaskRequest $request){
    try{

        $task = Task::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'user_id'=>auth()->user()->id,
        ]);

        if($task){
            return back()->with('msg','Tarefa adicionada');
        }else{
            
            return back()->with('error','Erro  ao adicionar tarefa');
         }
    }catch(\Exception $ex){
        return back()->with('error','Erro no servidor: '.$ex->getMessage());
    }
   }

   public function task_pending($id){
    $task = Task::find($id);
    $task->status = 'pending';
    $task->save();

    if($task){
        return back()->with('msg','Tarefa marcada como pendente');
    }

   }
   public function task_done($id){
    $task = Task::find($id);
    $task->status = 'done';
    $task->save();

    if($task){
        return back()->with('msg','Tarefa marcada como terminada');
    }

   }
   public function task_delete($id){
    $task = Task::destroy($id);

    if($task){
        return back()->with('msg','Tarefa excluida com sucesso.');
    }

   }

   public function report(){
    $task_done = Task::where('status','=','done')
       ->where('user_id','=',auth()->user()->id)->paginate(5);
    $task_pending = Task::where('status','=','pending')
    ->where('user_id','=',auth()->user()->id)->paginate(5);
    $pdf = Pdf::loadView('pages.report',compact('task_done','task_pending'));
    return $pdf->stream('relatorio_semanal_'.auth()->user()->name);
   }
  
}
