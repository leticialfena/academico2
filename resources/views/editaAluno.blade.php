@extends('template')
@section('conteudo')
    <h3> Edição de Estudante </h3>
    <h4> Editando estudante: {{ $aluno->nome }} </h4>
    <input type="hidden" id="id" value="{{ $aluno->id }}">
    @csrf
    <div class="container">
        
        <div class="msg alert d-none">

        </div>
       
        <div class="row">
            <div class="col-sm-5">
                Nome: <input type="text" id="nome" class="form-control" placeholder="Digite o nome" value="{{ $aluno->nome }}">
            </div>
            <div class="col-sm-4">
                Cpf: <input type="text" id="cpf" class="form-control" placeholder="###.###.###-##" onkeyup="mascara('###.###.###-##',this,event,true)" maxlength="14" value="{{ f_cpf($aluno->cpf) }}">
            </div>
            <div class="col-sm-3">
                Matricula: <input type="text" id="matricula" class="form-control" placeholder="Digite a matrícula" value="{{ $aluno->matricula}}">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">    
                Email: <input type="text" id="email" class="form-control" placeholder="Digite o email" value="{{ $aluno->email }}">
            </div>
            <div class="col-sm-6">
                Gitlab: <input type="text" id="gitlab" class="form-control" placeholder="Digite o gitlab" value="{{ $aluno->gitlab }}">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                Celular: <input type="text" id="celular" class="form-control" placeholder="(##) # ####-####" onkeyup="mascara('(##) # ####-####',this,event,true)" maxlength="16" value="{{ f_celular($aluno->celular) }}">
            </div>
            <div class="col-sm-6">
                @php $turma_aluno = $aluno->turma @endphp
                Turma: <select id="turma" name="turma">
                        @foreach ($turmas as $turma)
                            @if ($turma == $turma_aluno )
                                <option value="{{ $turma }}" selected > {{ $turma }} </option>
                            @else 
                                <option value="{{ $turma }}">{{ $turma }}</option>
                            @endif
                        @endforeach
                        </select>
            </div>
        </div>
        <br>
        <button type="button" id="salvar" class="btn btn-primary">Salvar dados</button>
    </div>

</div>
</div>
@stop
@section('rodape')
@stop
@section('js')
<script type="text/javascript">

    jQuery(document).ready(function(){

        var ExpRegMail = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);


        $("#salvar").click(function(){
            //alert('salvar');
            var _token = $("input[name='_token']").val();
            var id = $("#id").val();
            var nome = $("#nome").val();
            var cpf = $("#cpf").val();
            var matricula = $("#matricula").val();
            var email = $("#email").val();
            var gitlab = $("#gitlab").val();
            var celular = $("#celular").val();
            var turma = $("#turma").val();

            var ok = true;

            cpf = cpf.match(/\d/g).join("");
            celular = celular.match(/\d/g).join("");
            //alert('cpf: '+cpf);
            var rota = '{{ url("buscaCpf")}}'+'/'+cpf;
            //alert('rota: '+rota);

            var resposta = $.ajax({
                url: rota,
                method: 'GET',
                dataType: "html"
            });

            resposta.done(function(outroNome){
                if (outroNome != '' & outroNome != nome){
                    alert("CPF já utilizado por: "+outroNome)
                    ok = false;
                    $("#cpf").focus();
                }
            });

            if (!isValidCPF(cpf)){
                alert("CPF inválido!")
                ok = false;
                $("#cpf").focus();
            }


            if( email == '' || !ExpRegMail.test(email) ) { 
                alert('Preencha o campo email corretamente'); 
                ok = false;
                $("#email").focus();
             }

            //tudo certo, envia os dados
            if (ok){
                $.ajax({
                    url: '{{ route("salvaAluno")}}',
                    method: 'POST',
                    data: { _token: _token,
                        id : id, 
                        nome : nome, 
                        cpf:cpf,
                        matricula : matricula,
                        email : email, 
                        gitlab : gitlab,
                        celular: celular,
                        turma: turma},
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
            }
        });
    });

    function isValidCPF(cpf) {
        if (typeof cpf !== "string") return false
        cpf = cpf.replace(/[\s.-]*/igm, '')
        if (
            !cpf ||
            cpf.length != 11 ||
            cpf == "00000000000" ||
            cpf == "11111111111" ||
            cpf == "22222222222" ||
            cpf == "33333333333" ||
            cpf == "44444444444" ||
            cpf == "55555555555" ||
            cpf == "66666666666" ||
            cpf == "77777777777" ||
            cpf == "88888888888" ||
            cpf == "99999999999" 
        ) {
            return false
        }
        var soma = 0
        var resto
        for (var i = 1; i <= 9; i++) 
            soma = soma + parseInt(cpf.substring(i-1, i)) * (11 - i)
        resto = (soma * 10) % 11
        if ((resto == 10) || (resto == 11))  resto = 0
        if (resto != parseInt(cpf.substring(9, 10)) ) return false
        soma = 0
        for (var i = 1; i <= 10; i++) 
            soma = soma + parseInt(cpf.substring(i-1, i)) * (12 - i)
        resto = (soma * 10) % 11
        if ((resto == 10) || (resto == 11))  resto = 0
        if (resto != parseInt(cpf.substring(10, 11) ) ) return false
        return true
    }

</script>
<script src="{{ asset('js/mascara.js') }}"></script>
@stop
