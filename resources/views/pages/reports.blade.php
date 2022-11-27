@extends('dashboard')
@section('content')

<section>
   <h1 class="h4 text-primary uppercase font-bold">Gerar Relatório</h1>
    <form action="{{route('make.reports')}}" method="post" target="_blank">
        @csrf
        <div class="d-flex justify-content-center align-items-center col-md-12 gap-1">
            
            <div class="col-md-3">
                <label for="user">Funcionário:</label>
                <select name="user" id="user" class="form-control">
                    <option selected>Selecionar</option>
                    @foreach ($users as $user)
                    <option value="{{$user->id}}" class="font-bold">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-3">
                <label for="initial">Data de inicio:</label>
               <input type="date" name="initial" id="initial" class="rounded form-control">
            </div>
            <div class="col-md-3">
                <label for="final">Data de fim:</label>
               <input type="date" name="final" id="final" class="rounded form-control">
            </div>
            <div class="col-md-3">
                <button type="submit" class="mt-4 w-100 text-dark btn btn-md btn-primary">
                    Buscar
                </button>
            </div>

            
        </div>
    </form>
</section>

@endsection