<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\aluno;
use App\Models\nota;
use App\Models\falta;
use Session;

class DadosAcademicos extends Controller
{
    public function ListaAlunos(){
        $alunos = aluno::all();

        return view('pagina2')->with(compact('alunos'));
    }

    public function ListaDados($id){
        $nome  = aluno::where(['id' => $id])->select('nome')->first()->nome;
        $notas = nota::where(['id_aluno' => $id])->get();
        $faltas = falta::where(['id_aluno' => $id])->orderBy('mes')->get();

        return view('pagina3')->with(compact('nome','notas','faltas'));
    }

    public function cadastraAlunos(){
        $alunos = aluno::orderBy('nome')->get();
        return view('cadastraAlunos')->with(compact('alunos'));
    }

    public function editaAluno($id){
        $aluno = aluno::where(['id' => $id])->first();
        $turmas = ['AUT2D1','AUT2D2','AUT2D3'];
        //dd($aluno);
        return view('editaAluno')->with(compact(['aluno','turmas']));
    }

    public function buscaCpf($cpf){
        $aluno  = aluno::where(['cpf' => $cpf])->first();
        //dd($aluno);
        $nome = '';
        if ($aluno) $nome = $aluno->nome;
        return $nome;
    }

    public function salvaAluno(Request $request){
        $dados = $request->all();
        unset($dados['_token']);
        //print_r($dados);
        $aluno = aluno::where(['id' => $dados['id']])->first();
        try {
            unset($dados['id']);
            $aluno->fill($dados); 
            $aluno->save();
            $ret['ok'] = true;
            $ret['msg'] = 'Dados salvos com sucesso!';
        } 
        catch (\Exception $e){
            $ret['ok'] = false;
            $ret['msg'] = 'Erro ao salvar dados: '.$e;
        }

        echo json_encode($ret);
        return;
    }

    public function adicionaAluno(){
        $aluno = new aluno();
        $aluno->nome = "Novo Aluno";
        $aluno->matricula = "00000";
        $aluno->cpf = "00000";
        $aluno->email = "novo.email";
        $aluno->gitlab = "novo.gitlab";
        $aluno->celular = "123456";
        $aluno->save();
        return redirect('editaAluno/'.$aluno->id);
    }

    public function lancaNotas(){
        $alunos = aluno::orderBy('nome')->get();
        $notas = nota::get();
        //dd([$alunos, $notas]);
        return view('lancaNotas')->with(compact('alunos', 'notas'));        
    }

    public function salvaNotas(Request $request){
        $dados = $request->all();
        unset($dados['_token']);
        //print_r($dados);
        $nota = nota::where('id_aluno',$dados['id_aluno'])->first();
        if(is_null($nota) || $nota->count() == 0)
        {
            $nota = new nota;
        }

        $nota->fill($dados); 
        $nota->save();
        $ret['ok'] = true;
        $ret['msg'] = 'Notas salvas com sucesso!';

        echo json_encode($ret);
        return;
    }

    public function lancaFaltasMes(){
        $meses = falta::distinct()->orderBy('mes')->get(['mes']);
        return view('lancaFaltasMes')->with(compact('meses'));        
    }

    public function insereMes($novoMes){
        $alunos = aluno::all();
        foreach ($alunos as $aluno){
            $falta = new falta();
            $falta->mes = $novoMes;
            $falta->faltas = 0;
            $falta->id_aluno = $aluno->id;
            $falta->save();
        }
        return redirect('lancaFaltasMes');
    }

    public function lancaFaltas($mesSelecionado){

        $alunos = aluno::orderBy('nome')->get();
        //$faltas = falta::get();
        $meses = falta::distinct()->orderBy('mes')->get(['mes']);
        //dd([$meses]);

        return view('lancaFaltas')->with(compact('alunos','meses','mesSelecionado'));        
    }

    public function salvaFaltas(Request $request){
        $dados = $request->all();
        //dd($dados);
        unset($dados['_token']);
        //print_r($dados);
        $falta = falta::where('id_aluno',$dados['id_aluno'])->where('mes',$dados['mes'])->first();
        if(is_null($falta) || $falta->count() == 0)
        {
            $falta = new falta;
        }

        $falta->fill($dados); 
        $falta->save();
        $ret['ok'] = true;
        $ret['msg'] = 'Faltas salvas com sucesso!';

        echo json_encode($ret);
        return;
    }

}
