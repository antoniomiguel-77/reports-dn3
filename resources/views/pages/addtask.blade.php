@extends('dashboard')
@section('content')

<section class="d-flex justify-content-center align-items-center flex-wrap col-md-12">
   <h1 class="h4 text-primary uppercase font-bold">Adicione uma tarefa por fazer...</h1>
<form action="{{(Route::Current()->getName() === 'edit.task')? route('update.task'):route('save.task')}}" method="post" class="col-md-12">
    @csrf
        <div class="col-md-12">
            <label for="name">Tarefa:</label>
            <input type="text" name="name" id="name" value="{{$task->name ?? ''}}" class="form-control @error('name') is-invalid @enderror" placeholder="Digite aqui sua tarefa">
            @error('name')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="col-md-12">
            <label for="description">Descrição:</label>
            <textarea name="description" id="description" style="resize: none;" placeholder="Descreve a tarefa..." class="form-control @error('description') is-invalid @enderror">
                {{$task->description ?? ''}}
            </textarea>
           @error('description')
                <span class="text-danger">{{$message}}</span>
           @enderror

           @if (isset($task))
               <input type="hidden" name="id" value="{{$task->id}}">
           @endif
        </div>
        <div class="col-md-12 mt-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary text-dark">
                {{(Route::Current()->getName() === 'edit.task')? 'Actualizar':'Salvar'}}
                
            </button>
        </div>
   </form>
</section>

@endsection