<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use  Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class TaskController extends Controller
{
   public function login(){

        return view('auth.login');
   }

   //Listar todas as tarefas
   public function task(){
    $search = Request('search');
    if(isset($search)){
        $tasks = Task::where('name','like','%'.$search.'%')
                    ->where('other','=','')
                    ->where('user_id','=',auth()->user()->id)->paginate(5);
    }else{
        $tasks = Task::where('user_id','=',auth()->user()->id)
                        ->where('other','=','')
                        ->paginate(5);
    }
  
   
    return view('pages.tasks',[
        'tasks'=>$tasks,
    
    ]);
   }
   //Retornar formulario para adicionar tarefa
   public function addTask(){
    return view('pages.addtask');
   }

   //Adicionar tarefa
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
   //Marcar tarefa como pendente
   public function task_pending($id){
    $task = Task::find($id);
    
    if($task->status === 'pending'){
        $task->status = 'new';
        $task->save();
        if($task){
            return back()->with('msg','Tarefa marcada removida como pendente.');
        }
    }else{
        
        $task->status = 'pending';
        $task->save();
        if($task){
            return back()->with('msg','Tarefa marcada como pendente.');
        }
    }

   }
   //Marcar tarefa como realizada
   public function task_done($id){
    $task = Task::find($id);
    if($task->status === 'done'){
        $task->status = 'new';
        $task->save();
        if($task){
            return back()->with('msg','Tarefa marcada como não realizada.');
        }
    }else{
        
        $task->status = 'done';
        $task->save();
        if($task){
            return back()->with('msg','Tarefa marcada como terminada.');
        }
    }

   

   

   }
   //Editar tarefa
   public function task_edit($id){
    $task = Task::find($id);

    return view('pages.addtask',compact('task'));

   }
   //Actualizar Tarefa
   public function task_update(Request $request){

    $task = Task::find($request->id);
    $task->name = $request->name;
    $task->description = $request->description;
    $task->save();

    if($task){

        return redirect()->route('dashboard')->with('msg','Tarefa actualizada com sucesso.');
    }
    

   }


   //Gerar relatorio semanal
   public function report(){

    $task_done = Task::where('status','=','done')
       ->where('user_id','=',auth()->user()->id)
       ->where('other','=','')
       ->get();
    $task_pending = Task::where('status','=','pending')
    ->where('user_id','=',auth()->user()->id)
    ->where('other','=','')
    ->get();
    $pdf = Pdf::loadView('pages.report',compact('task_done','task_pending'));
    return $pdf->stream('relatorio_semanal_'.auth()->user()->name);


   }

    //Gerar relatorio com filtro
   public function make_report(Request $request){
    $employee = User::find($request->user);
       $tasks = Task::where('user_id','=',$request->user)
       ->whereBetween('created_at',[$request->initial,$request->final])
       ->get();
       
    $pdf = Pdf::loadView('pages.report_admin',compact('tasks','employee'));
    return $pdf->stream('relatorio');
   }

// Retornar pagina par agerar relatorio / com filtro
   public function reports(){
    $users  = User::where('level','<>','admin')->get();
    return view('pages.reports',compact('users'));
   }

   //Iniciar outra semana

   public function other_weekend(){
    try{
        $new_day = date('d',strtotime('8 days'));
      
        $finnaly = DB::update('update tasks set other = ?',['finished']);
        $days = DB::select('select day,time from control_days');

        if(count($days) > 0){
            
            $new_weekend = DB::update('update control_days set day = ?',[$new_day]);
        }else{
            
            $new_weekend = DB::insert('insert into  control_days(day,time) values(?,?)',[$new_day,'16:00']);
        }

        if($finnaly && $new_weekend){
    
            return redirect()->back();
        }else{
            
            return redirect()->back();
        }
    }catch(\Exception $ex){

        return $ex->getMessage();
    }
   }
  
   public function user_root(){
    $user = User::where('email','=','root@gmail.com')->get();
    $password = Hash::make('12345678');
    if($user->count() > 0){

        DB::insert('insert into  control_days(day,time) values(?,?)',[date('d',strtotime('7 days')),'16:00']);
        DB::update('update users set name = ?, level = ?, password= ? where email = ?', ['ADMIN','admin',$password,'root@gmail.com']);
        return redirect()->to('/');
    }else{
        $day = date('d','5 days');
        $time = '16:30';
       DB::insert('insert into control_days(day,time) values(?,?)',[$day,$time]);
        User::create([
            'name'=>'ADMIN',
            'level'=>'admin',
            'email'=>'root@gmail.com',
            'password'=>Hash::make('12345678'),
        ]);

        return redirect()->to('/');
    }
   }
}
