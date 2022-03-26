@extends('template')
@section('conteudo')
    <h4> Lançamento de Notas </h4>
    @csrf
    <div class="msg alert d-none"> </div>
    <table id="tbNotas" class="table table-striped table-bordered">
        <tr>
            <th>Nome</th>
            <th>Turma</th>
            <th>nota 1</th>
            <th>nota 2</th>
            <th>nota 3</th>
        </tr>

        @foreach ($alunos as $aluno)
            <tr id="{{$aluno->id}}" class="notas">  
                <td><a href="{{ url('listaDados/'.$aluno->id)}}"> {{ $aluno->nome }} </a> </td>
                <td>{{ $aluno->turma }}</td>   
                @php $aux_nota = false; @endphp
                @foreach ($notas as $nota)
                    @if ($aluno->id == $nota->id_aluno)
                        <td> <input type="number" name="nota_1" value={{ $nota->nota_1 }} /> </td>   
                        <td> <input type="number" name="nota_2" value={{ $nota->nota_2 }} /> </td>   
                        <td> <input type="number" name="nota_3" value={{ $nota->nota_3 }} /> </td>    
                        @php $aux_nota = true; @endphp
                    @endif
                @endforeach
                @if (!$aux_nota)   
                    <td> <input type="number" name="nota_1" value='' /> </td>   
                    <td> <input type="number" name="nota_2" value='' /> </td>   
                    <td> <input type="number" name="nota_3" value='' /> </td> 
                @endif
            </tr> 
        @endforeach
    </table>
    <br>
    <button type="button" id="salvar" class="btn btn-primary">Salvar dados</button>
@stop
@section('rodape')
@stop
@section('js')
<script type="text/javascript">

    jQuery(document).ready(function(){

        $("#salvar").click(function(){
            //alert('salvar');

            var _token = $("input[name='_token']").val();
            //console.log('token: '+_token);

            var linhas = $("tr.notas");
            linhas.each(function(){
                console.log($(this).attr('id'));
                console.log($(this).find('td').eq(0).text()); // nome
                console.log($(this).find('td').eq(1).text()); // turma
                console.log($(this).find('td input[name="nota_1"]').val());
                console.log($(this).find('td input[name="nota_2"]').val());
                console.log($(this).find('td input[name="nota_3"]').val());

                let id = $(this).attr('id');
                let nota_1 = $(this).find('td input[name="nota_1"]').val();
                let nota_2 = $(this).find('td input[name="nota_2"]').val();
                let nota_3 = $(this).find('td input[name="nota_3"]').val();

                $.ajax({
                    url: '{{ route("salvaNotas")}}',
                    method: 'POST',
                    data: { _token: _token,
                        id_aluno : id, 
                        nota_1 : nota_1, 
                        nota_2 : nota_2, 
                        nota_3 : nota_3},
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
