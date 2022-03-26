@extends('template')
@section('conteudo')
    <h4> Lançamento de Faltas do mês: {{$mesSelecionado}}</h4>
    @csrf
    <input type="hidden" id="mesSelecionado" name="mesSelecionado" value="{{$mesSelecionado}}" /> 
    <div class="msg alert d-none"> </div>
    <table id="tbFaltas" class="table table-striped table-bordered">
        <tr>
            <th>Nome</th>
            <th>Turma</th>
            <th>mês {{$mesSelecionado}}</th>
        </tr>

        @foreach ($alunos as $aluno)
            <tr id="{{$aluno->id}}" class="faltas" >  
                <td><a href="{{ url('listaDados/'.$aluno->id)}}"> {{ $aluno->nome }} </a> </td>
                <td>{{ $aluno->turma }}</td>   
                <td> <input type="number" class="falta col-sm-2 border" value="{{ $aluno->getFaltas($mesSelecionado) }}" /> </td>   
            </tr> 
        @endforeach
    </table>
    <br>
    <button type="button" id="salvar" class="btn btn-primary">Salvar Faltas</button>
@stop
@section('rodape')
@stop
@section('js')
<script type="text/javascript">

    jQuery(document).ready(function(){

        $("#salvar").click(function(){
            let _token = $("input[name='_token']").val();
            //console.log('token: '+_token);
            let mesSelecionado = $("#mesSelecionado").val();
            //alert(mesSelecionado);
            let linhas = $("tr.faltas");
            linhas.each(function(){
                console.log($(this).attr('id'));
                console.log($(this).find('td').eq(0).text()); // nome
                console.log($(this).find('td').eq(1).text()); // turma
                console.log($(this).find('td').eq(2).val()); //faltas
                console.log($(this).find('td input').val());


                let id = $(this).attr('id');
                let faltas = $(this).find('td input').val();
                
                $.ajax({
                    url: '{{ route("salvaFaltas")}}',
                    method: 'POST',
                    data: { _token: _token,
                        id_aluno : id, 
                        mes : mesSelecionado, 
                        faltas : faltas},
                    dataType: 'json',
                    success: function (data){
                        console.log(data);
                        if(data.ok === true){
                            //window.location.href = "{{ route('cadastraAlunos')}}";
                            $('.msg').removeClass('d-none').addClass('alert-success').html(data.msg)
                        } else {
                            $('.msg').removeClass('d-none').addClass('alert-danger').html(data.msg);
                        }
                    }
                });
            });
        });
    });
</script>
@stop
