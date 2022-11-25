<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Acesso ao sistema
Route::controller(TaskController::class)->group(function(){
    Route::get('/','login')->name('login');
    Route::get('/tarefas','task')->name('dashboard')->middleware(['auth', 'verified']);
    Route::get('/adicionar/tarefas','addTask')->name('add.task')->middleware(['auth', 'verified']);
    Route::post('/tarefas','save')->name('save.task')->middleware(['auth', 'verified']);
    
    
    Route::get('/pendente/{id}','task_pending')->name('pause.task')->middleware(['auth', 'verified']);
    Route::get('/terminada/{id}','task_done')->name('pause.task')->middleware(['auth', 'verified']);
    Route::get('/deletar/{id}','task_delete')->name('delete.task')->middleware(['auth', 'verified']);
    
    Route::get('/relatorio','report')->name('report.task')->middleware(['auth', 'verified']);
    
    

});

// Criar usuario root
Route::get("/root",function(){
    $user = User::where('email','=','root@gmail.com')->get();
    $password = Hash::make('12345678');
    if($user->count() > 0){

        DB::update('update users set name = ?, level = ?, password= ? where email = ?', ['ADMIN','admin',$password,'root@gmail.com']);
        return redirect()->to('/');
    }else{

        User::create([
            'name'=>'ADMIN',
            'level'=>'admin',
            'email'=>'root@gmail.com',
            'password'=>Hash::make('12345678'),
        ]);
        return redirect()->to('/');
    }

 });
 //Fim 


 Route::get('/fresh',function(){
    Artisan::call('migrate:fresh');
    return redirect()->back();
 });




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
