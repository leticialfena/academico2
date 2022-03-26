@extends('template')
@section('conteudo')
    <h4> Dados de: {{ $nome }} </h4>

    <h6> Notas </h6>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Nota 1</th>
            <th>Nota 2</th>
            <th>Nota 3</th>
        </tr>
        @foreach ($notas as $nota)
            <tr>
                <td>{{ $nota->nota_1 }}</td>  
                <td>{{ $nota->nota_2 }}</td>   
                <td>{{ $nota->nota_3 }}</td>    
 
            </tr> 
        @endforeach
    </table>

    <h6> Faltas </h6>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Mês</th>
            <th>Faltas</th>
        </tr>
        @foreach ($faltas as $falta)
            <tr>
                <td>{{ $falta->mes }}</td>  
                <td>{{ $falta->faltas }}</td>   
            </tr> 
        @endforeach
    </table>
@stop
@section('rodape')
    <h4> rodapé da página 3 </h4>
@stop
