<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PremioController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\DistribuicaoController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\GraficoController;
use Illuminate\Support\Facades\Auth;
use App\Models\Funcionario;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Funcionario controller */
Route::post('/entrar', [FuncionarioController::class, 'login']);
Route::get('/', [FuncionarioController::class, 'dashboard'])->middleware('auth');
Route::get('dashboard', [FuncionarioController::class, 'dashboard'])->middleware('auth');
Route::get('/sorteio', [FuncionarioController::class, 'sorteio'])->middleware('auth');
Route::get('/atualizarSenha', [FuncionarioController::class, 'atualizarSenha'])->middleware('auth');
Route::post('/reiniciarSenha', [FuncionarioController::class, 'reiniciarSenha'])->middleware('auth');

/* Premio controller */
Route::post('/premio', [PremioController::class, 'store'])->middleware('auth');
Route::get('/premio/criar', [PremioController::class, 'create'])->middleware('auth');
Route::get('/premio/{id}', [PremioController::class, 'show'])->middleware('auth');
Route::get('/produtos/{id}', [PremioController::class, 'product'])->middleware('auth');
Route::get('/produtos/editar/{id}', [PremioController::class, 'productEdit'])->middleware('auth');
Route::get('/produtos/limpar/{id}', [PremioController::class, 'zerarValores'])->middleware('auth');
Route::post('/premio/atualizarContagem', [PremioController::class, 'atualizarContagem'])->middleware('auth');
Route::post('/premio/zerarContagem', [PremioController::class, 'zerarContagem'])->middleware('auth');
Route::post('/premio/atualizar', [PremioController::class, 'update'])->middleware('auth');

/* Distribuição controller */
Route::post('/distribuicao/coordenador', [DistribuicaoController::class, 'distribuir'])->middleware('auth');
Route::get('/distribuicao/coordenador/{id}', [DistribuicaoController::class, 'escolher'])->middleware('auth');
Route::post('/distribuicao/supervisor', [DistribuicaoController::class, 'distribuicaoSupervisor'])->middleware('auth');
Route::get('/distribuicao/coordenador/confirmar/{id}', [DistribuicaoController::class, 'coordenadorAceitar'])->middleware('auth');
Route::get('/distribuicao/coordenador/cancelar/{id}', [DistribuicaoController::class, 'coordenadorCancelar'])->middleware('auth');
Route::get('/distribuicao/coordenador/sortear/{id}', [DistribuicaoController::class, 'sortearSupervisor'])->middleware('auth');
Route::post('/distribuicao/supervisorSorteado', [DistribuicaoController::class, 'supervisorSorteado'])->middleware('auth');

/* Supervisor Controller */
Route::post('distribuicao/colaborador', [SupervisorController::class, 'enviarColaborador'])->middleware('auth');
Route::get('distribuicao/colaborador/{id}', [SupervisorController::class, 'distribuicaoColaborador'])->middleware('auth');
Route::get('/distribuicao/supervisor/confirmar/{id}', [SupervisorController::class, 'supervisorAceitar'])->middleware('auth');
Route::get('/distribuicao/supervisor/cancelar/{id}', [SupervisorController::class, 'supervisorCancelar'])->middleware('auth');

/* Colaborador controller */
Route::get('colaborador/confirmar/{id}', [ColaboradorController::class, 'confirmarRecebimento'])->middleware('auth');
Route::post('/colaborador/sorteado', [ColaboradorController::class, 'colaboradorSorteado'])->middleware('auth');

/* Grafico controller */
Route::get('/graficos', [GraficoController::class, 'grafico'])->middleware('auth');
Route::get('/graficos/cadastrado', [GraficoController::class, 'totalCadastrado'])->middleware('auth');
Route::get('/graficos/coordenador', [GraficoController::class, 'totalCoordenador'])->middleware('auth');
Route::get('/graficos/supervisor', [GraficoController::class, 'totalSupervisor'])->middleware('auth');

Route::get('/premios', function () { return view('premios'); });