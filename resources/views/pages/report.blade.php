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
            <h3>Relatório Semanal das Actividades</h3>
        </div>
        <div style="text-align:center; border:1px solid black; margin-left: 1px">
                <span style="font-weight: bold">Funcionário: </span><span>{{auth()->user()->name}}</span> |
                <span style="font-weight: bold">Data: </span><span>{{date('d-m-Y H:i:s')}}</span>
        </div>
            <h4 style="text-decoration: underline">Tarefas Realizadas</h4>
                <table border="1" style="width: 44rem; border-collapse: collapse;text-align: center;margin-left: 1px">
                    <thead>
                        <tr>
                            <th scope="col">Tarefa</th>
                            <th scope="col">Descrição</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($task_done->count() > 0)
                        @foreach ($task_done as $item)
        
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->description}}</td>
                        </tr>
                        @endforeach
                        @else
                         <tr>
                            <td colspan="2">Nenhuma tarefa realizada</td>
                         </tr>
                        @endif
                    </tbody>
                </table>
            <h4 style="text-decoration: underline">Tarefas Pendentes</h4>
                <table border="1" style="width: 44rem; border-collapse: collapse;text-align: center; margin-bottom: 4rem; margin-left: 1px">
                    <thead>
                        <tr>
                            <th scope="col">Tarefa</th>
                            <th scope="col">Descrição</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($task_pending->count() > 0)
                        @foreach ($task_pending as $item)
        
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->description}}</td>
                        </tr>
                        @endforeach
                        @else
                         <tr>
                            <td colspan="2">Nenhuma tarefa pendente</td>
                         </tr>
                        @endif
                    </tbody>
                </table>
                    <div style="text-align: center">
                        <span style="font-weight: bold; margin-botton:3rem">Aprovado por:_________________________</span>
                        <span style="font-weight: bold; margin-left:2rem;">Data:____/_____/________</span>
                    </div>
        
</body>
</html>