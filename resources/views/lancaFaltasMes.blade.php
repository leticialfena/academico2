@extends('template')
@section('conteudo')
    <h4> Lançamento de Faltas </h4>
    @csrf
    <h5>
        <div class="form-group ">
            <label for="mes" class="col-sm-2 col-form-label">Selecione o mês: </label>
            <select name="meses" id="meses" class="col-sm-1">
                @foreach ($meses as $mes)
                    <option value={{$mes->mes}}>{{$mes->mes}} </option>
                @endforeach
            </select>
            <label for="mes" class="col-sm-2 col-form-label">Inserir novo mês: </label>
            <input type="number"  name="novoMes" id="novoMes" class="col-sm-1 border"/>
            <button type="button" id="inserirMes" class="btn btn-primary d-none">Inserir</button>
        </div>
    </h5>
    <div class="msg alert d-none"> </div>
@stop
@section('rodape')
@stop
@section('js')
<script type="text/javascript">

    jQuery(document).ready(function(){
        
        $("#meses").click(function(){
            let mesSelecionado = $("#meses").val();
            //alert(mesSelecionado);
            url = '{{ url("/")}}'+'/lancaFaltas/'+mesSelecionado;
            //alert(url);
            window.location.href = url;
        });

        $("#novoMes").change(function(){
            $('#inserirMes').removeClass('d-none');
            $('.msg').addClass('d-none');
        });

        $("#inserirMes").click(function(){
            let novoMes = $("#novoMes").val();
            let meses = [];
            let opcoes = $("#meses option");

            for (let i=0; i< opcoes.length; i++){
                meses.push(opcoes[i].text);
            }

            //alert(meses);
            //alert($("#novoMes").val());
            if (meses.includes(novoMes)){
                $('.msg').removeClass('d-none').addClass('alert-danger').html("Mês: "+novoMes+" já existe na lista de meses!");
            }else{
                url = '{{ url("/")}}'+'/insereMes/'+novoMes;
                //alert(url);
                window.location.href = url;
            }
            $(this).addClass('d-none');
        });
    });
</script>
@stop
