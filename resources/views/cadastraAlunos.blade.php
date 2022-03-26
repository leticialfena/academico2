@extends('template')
@section('conteudo')
    <h4> Cadastro de Estudantes </h4>
    <label for="estudantes">Selecione um estudante:</label>

    <select name="estudantes" id="estudantes">
        @foreach ($alunos as $aluno)
            <option value={{ $aluno->id }}>{{ $aluno->nome }}</option>
        @endforeach
    </select>
    <div >
        <a href="{{ route('adicionaAluno')}}" class="btn btn-info" >Adicionar Novo Estudante</a>
    </div>

@stop
@section('rodape')
@stop
@section('js')
<script type="text/javascript">
    jQuery(document).ready(function(){
        var URL_SITE = "{{ URL::to('/') }}";

        jQuery("#estudantes").click(function(){
            //var id = $("#estudantes").val();
            var id = $(this).val();

            window.location.href = URL_SITE + "/editaAluno/" + id;
        });
    });
</script>
@stop
