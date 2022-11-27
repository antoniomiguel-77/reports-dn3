<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório Semanal</title>
</head>
<body style="border-left: 40px solid #ff6600">
    <img src="dn3.png" alt="logo" style="width: 170px; height:170px; margin-left:16rem; margin-top:-4rem;">

    <div style="text-align: center; margin-top:-3rem">
        <h3>Relatório de Actividades</h3>
    </div>
    <div style="text-align:center; border:1px solid black; margin-left: 1px">
            <span style="font-weight: bold">Funcionário: </span><span>{{$employee->name}}</span> |
            <span style="font-weight: bold">Data: </span><span>{{date('d-m-Y H:i:s')}}</span>   
    </div>

        <h4 style="text-decoration: underline">Tarefas Realizadas</h4>

            <table border="1" style="width: 44rem; border-collapse: collapse;text-align: center; font-size: 12px;margin-left: 1px">
                <thead>
                    <tr>
                        <th scope="col">Tarefa</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Data de Realização</th>
                    </tr>
                </thead>
                <tbody>
                    @if($tasks->count() > 0)
                    @foreach ($tasks as $item)
                        
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->description}}</td>
                        <td>{{\Carbon\Carbon::parse($item->created_at)->format('d-m-Y')}}</td>
                    </tr>
                    @endforeach
                    @else
                     <tr>
                        <td colspan="3">Nenhuma tarefa realizada</td>
                     </tr>
                    @endif
                </tbody>
            </table>


                <div style="text-align: center; margin-top:4rem">
                    <span style="font-weight: bold; margin-botton:3rem">Aprovado por:_________________________</span>
                    <span style="font-weight: bold; margin-left:2rem;">Data:_____/_____/________</span>
                </div>
        
</body>
</html>