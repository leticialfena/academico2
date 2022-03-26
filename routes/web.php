<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DadosAcademicos;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('principal');
});

Route::get('/principal', function () {
    return view('principal');
})->name('principal');

Route::get('/pagina2', [DadosAcademicos::class,'ListaAlunos'])->name('listaAlunos');

Route::get('/listaDados/{id}', [DadosAcademicos::class,'ListaDados'])->name('listaDados');

Route::get('/cadastraAlunos', [DadosAcademicos::class,'cadastraAlunos'])->name('cadastraAlunos');

Route::get('/editaAluno/{id}', [DadosAcademicos::class,'editaAluno'])->name('editaAluno');

Route::get('/buscaCpf/{cpf}', [DadosAcademicos::class,'buscaCpf'])->name('buscaCpf');

Route::post('/salvaAluno', [DadosAcademicos::class,'salvaAluno'])->name('salvaAluno');

Route::get('/adicionaAluno', [DadosAcademicos::class,'adicionaAluno'])->name('adicionaAluno');

Route::get('/lancaNotas', [DadosAcademicos::class,'lancaNotas'])->name('lancaNotas');

Route::post('/salvaNotas', [DadosAcademicos::class,'salvaNotas'])->name('salvaNotas');

Route::get('/lancaFaltasMes', [DadosAcademicos::class,'lancaFaltasMes'])->name('lancaFaltasMes');

Route::get('/insereMes/{novoMes}', [DadosAcademicos::class,'insereMes'])->name('insereMes');

Route::get('/lancaFaltas/{mes}', [DadosAcademicos::class,'lancaFaltas'])->name('lancaFaltas');

Route::post('/salvaFaltas', [DadosAcademicos::class,'salvaFaltas'])->name('salvaFaltas');
