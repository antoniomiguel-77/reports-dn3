<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Models\Task;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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
Route::controller(TaskController::class)->prefix('/')->group(function(){
    Route::get('/','login')->name('login');
    Route::get('/tarefas','task')->name('dashboard')->middleware(['auth', 'verified']);
    Route::get('/adicionar/tarefas','addTask')->name('add.task')->middleware(['auth', 'verified']);
    Route::post('/tarefas','save')->name('save.task')->middleware(['auth', 'verified']);
    
    
    Route::get('/pendente/{id}','task_pending')->name('pause.task')->middleware(['auth', 'verified']);
    Route::get('/terminada/{id}','task_done')->name('pause.task')->middleware(['auth', 'verified']);
    Route::get('/editar/{id}','task_edit')->name('edit.task')->middleware(['auth', 'verified']);
    Route::post('/actualizar','task_update')->name('update.task')->middleware(['auth', 'verified']);
    
    Route::get('/relatorios','reports')->name('reports')->middleware(['auth', 'verified','admin']);
    Route::post('/relatorios','make_report')->name('make.reports')->middleware(['auth', 'verified','admin']);
    Route::get('/relatorio','report')->name('report.task')->middleware(['auth', 'verified']);
    
    

    Route::get('/other','other_weekend')->name('new_weekend')->middleware(['auth', 'verified','admin']);
    // Criar usuario root
    Route::get("/root",'user_root');
    //Fim 
});

Route::get("/date",function(){
    $dateNow = date('H:i');
    $time = '13:23';

        if($dateNow === $time){

            return 'igual';
        }
  
            return $dateNow;
});






Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
