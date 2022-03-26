@extends('template')
@section('conteudo')
    <h4> Listagem de Estudantes </h4>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Id</th>
            <th>Matrícula</th>
            <th>Cpf</th>
            <th>Nome</th>
            <th>Email</th>
            <th>GitLab</th>
            <th>Celular</th>
            <th>Turma</th>
        </tr>
        @foreach ($alunos as $aluno)
            <tr>
                <td>{{ $aluno->id }}</td>  
                <td>{{ $aluno->matricula }}</td>   
                <td>{{ $aluno->cpf }}</td>    
                <td><a href="{{ url('listaDados/'.$aluno->id)}}"> {{ $aluno->nome }} </a> </td>
                <td>{{ $aluno->email }}</td>   
                <td>{{ $aluno->gitlab }}</td>   
                <td>{{ $aluno->celular }}</td>   
                <td>{{ $aluno->turma }}</td>   
            </tr> 
        @endforeach
    </table>
@stop
@section('rodape')
    <h4> rodapé da página 2 </h4>
@stop
