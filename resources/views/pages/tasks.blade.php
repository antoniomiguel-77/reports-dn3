@extends('dashboard')
@section('content')

<section class="d-flex justify-content-center align-items-center flex-wrap col-md-12">
    <div class="d-flex justify-content-end align-items-center flex-wrap col-md-12">
      <form >
          <input type="search" name="search" class="form-contol" id="search" placeholder="pesquisar tarefa">
      </form>
    </div>
    <table class="table table-bordered  mt-4 " style="text-align: center">
        <thead class="table-dark">
            <tr>
                <th>Tarefa</th>
                <th>Descrição</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>

            @if ($tasks->count() > 0)
                @foreach ($tasks as $item)
                    <tr class="{{($item->status === 'done')? ' alert alert-success text-decoration-line-through text-danger font-bold text-danger':''}} {{($item->status === 'pending')? ' alert alert-warning font-bold':''}}">
                        <td>{{$item->name}}</td>
                        <td>{{$item->description}}</td>
                        <td>
                            <a href="terminada/{{$item->id}}" class="btn btn-sm btn-outline btn-primary shadow-lg" title="Marcar Tarefa como terminada">
                                <i class="fa fa-check"></i>
                            </a>
                            <a href="pendente/{{$item->id}}" class="mt-1 btn btn-sm btn-outline btn-warning shadow-lg" title="Realizar mais tarde">
                                <i class="fa fa-pause"></i>
                            </a>
                            <a href="editar/{{$item->id}}" class="mt-1 btn btn-sm btn-outline btn-info shadow-lg" title="Editar tarefa">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach

            @elseif(Request('search'))
            <tr class="alert alert-info">
                <td colspan="5">Pesquisou por <span class="font-bold  ">({{Request('search')}})</span>  <a href="{{route('dashboard')}}" class="btn btn-sm btn-primary">Carregar tudo.</a></td>
            </tr>
            @else 
            <tr class="alert alert-info text-center">
                <td colspan="5">Nenhum tarefa adicionada</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="d-flex col-md-12 justify-content-end">
        {{$tasks->links('pagination::bootstrap-4')}}

   </div>
</section>

@endsection