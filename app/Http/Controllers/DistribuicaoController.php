<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CadastroPremio;
use App\Models\Funcionario;
use App\Models\Distribuicao;
use App\Models\Supervisor;
use Illuminate\Support\Facades\Auth;
use App\Events\NovoPremioCadastrado;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\NovoPremioCadastradoMail;

class DistribuicaoController extends Controller
{
    public function distribuir(Request $request)
    {
        $search = request('search');
        $user = Auth::user();
        $msg = null;

        $cadastrado = CadastroPremio::where('id', '=', $request->id_premio)->first();
        $quantidade_atual = htmlspecialchars($cadastrado->quantidade);
        $quantidade_distribuida = $request->quantidade;
        
        $cargos = Funcionario::where([
            ['matricula', '=', $user->matricula]
        ])->first();

        //dd($cargos);

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);

        $distribuicao = new Distribuicao();
        $distribuicao->id_premio = $request->id_premio;
        $distribuicao->matricula_coordenador = $request->coordenadores;
        $distribuicao->quantidade_recebida = $request->quantidade;
        $distribuicao->quantidade_distribuida = 0;
        $distribuicao->status_recebimento = 0;
        $distribuicao->total_recebido = $request->quantidade;
        $distribuicao->quantidade_temporaria = $request->quantidade;
        $distribuicao->data_recebida = date('Y-m-d H:i:s');

        $distribuicao->save();

        $coordenador = User::where([['matricula', '=', $request->coordenadores]])->first();
        //dd($coordenador);

        $enviado = Mail::to($coordenador->email)->send(new NovoPremioCadastradoMail($coordenador, $cadastrado, $request->quantidade));
        //dd($enviado);

        $atuliza_premio = $quantidade_atual - $quantidade_distribuida;

        $premio = new CadastroPremio();
        $premio->id = $request->id_premio;
        $premio->premio = $cadastrado->premio;
        $premio->descricao = $cadastrado->descricao;
        $premio->imagem = $cadastrado->imagem;
        $premio->item = $cadastrado->item;
        $premio->quantidade = $atuliza_premio;
        //$premio->save();
        $salvo = CadastroPremio::updateOrCreate(['id' => $premio->id], ['quantidade' => $premio->quantidade]);

        if($salvo)
        {
            $msg = "Premio ".$cadastrado->premio." distribuido com sucesso ";
        }

        $premio_cadastrado = CadastroPremio::All();

        return redirect()->to('/dashboard')->with(['premio_cadastrado' => $premio_cadastrado, 'search' => $search, 
                'cargo' => $cargo, 'campanha' => $campanha, 'msg' => $msg]);
    }

    public function escolher($id)
    {
        $user = Auth::user();
        
        $cargos = Funcionario::where([
            ['matricula', '=', $user->matricula]
        ])->first();

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);

        $distribuir = Distribuicao::findOrFail($id);
        $premio = CadastroPremio::findOrFail($distribuir->id_premio);

        $supervisores = Funcionario::where([
            ['matricula_supervisor', '=', $user->matricula],
            ['id_campanha', '=', 26],
            ['ativo', '=', 1 ]
        ])->get();

        return view('premio.escolher_supervisor', ['cargo' => $cargo, 'campanha' => $campanha, 
                    'distribuir' => $distribuir, 'premio' => $premio, 'supervisores' => $supervisores]);
    }

    public function distribuicaoSupervisor(Request $request)
    {
        $user = Auth::user();
        $msg = null;

        $cargos = Funcionario::where([
            ['matricula', '=', $user->matricula]
        ])->first();

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);

        $distribuido = new Distribuicao();
        $distribuido = Distribuicao::where([['id', '=', $request->id]])->first();

        $distribuido->quantidade_recebida = $distribuido->quantidade_recebida - $request->quantidade;
        $distribuido->quantidade_distribuida = $request->quantidade;

        $atualizado = Distribuicao::updateOrCreate(['id' => $distribuido->id], 
                                                   ['quantidade_recebida' => $distribuido->quantidade_recebida,
                                                    'quantidade_distribuida' => $distribuido->quantidade_distribuida,
                                                    'total_recebido' => $distribuido->total_recebido]);   

        $supervisor = new Supervisor();
        $supervisor->matricula_supervisor = $request->supervisor;
        $supervisor->id_premio = $request->id_premio;
        $supervisor->disponivel = $request->quantidade;
        $supervisor->distribuido = 0;
        $supervisor->data_recebida = date('Y-m-d H:i:s');

        $criado = Supervisor::updateOrCreate(['id' => $supervisor->id],
                                             ['matricula_supervisor' => $supervisor->matricula_supervisor,
                                              'id_premio' => $supervisor->id_premio,
                                              'disponivel' => $supervisor->disponivel,
                                              'distribuido' => $supervisor->distribuido,
                                              'data_recebida' => $supervisor->data_recebida]);
        if($criado)
        {
            $msg = "Premio distribuido com sucesso!";

            $premio_cadastrado = Distribuicao::where([['matricula_coordenador', '=', $user->matricula]])->get();

            return redirect()->to('/dashboard')->with(['premio_cadastrado' => $premio_cadastrado, 
                                                       'cargo' => $cargo, 'campanha' => $campanha, 'msg' => $msg]);
        }
        else
        {
            $msg = '';
            $premio_cadastrado = Distribuicao::where([['matricula_coordenador', '=', $user->matricula]])->get();
            return redirect()->to('/dashboard')->with(['premio_cadastrado' => $premio_cadastrado, 
                                                       'cargo' => $cargo, 'campanha' => $campanha, 'msg' => $msg]);
        }

    }

    public function coordenadorAceitar($id)
    {
        
        $atualizar_contagem = Distribuicao::where([['id', '=', $id]])->first();
        
        $atualiza_recebido = $atualizar_contagem->quantidade_recebida + $atualizar_contagem->quantidade_temporaria;
        
        $quantidade_temporaria = 0;
        
        $atualizar_total = Distribuicao::updateOrCreate(['id' => $id],
                                                        ['quantidade_recebida' => $atualiza_recebido,
                                                         'status_recebimento' => 1,
                                                         'quantidade_temporaria' => $quantidade_temporaria]);

        return redirect()->to('dashboard');
    }

    public function coordenadorCancelar($id)
    {
        $atualizar_contagem = Distribuicao::where([['id', '=', $id]])->first();

        $contagem_original = CadastroPremio::where('id', '=', $atualizar_contagem->id_premio)->first();

        $contagem_final = $contagem_original->quantidade + $atualizar_contagem->quantidade_temporaria;

        $salvo = Distribuicao::updateOrCreate(['id' => $id], ['status_recebimento' => 2, 'quantidade_temporaria' => 0]);

        $atualizado = CadastroPremio::updateOrCreate(['id' => $atualizar_contagem->id_premio], 
                                                     ['quantidade' => $contagem_final]);

        return redirect()->to('dashboard');
    }

    public function sortearSupervisor($id)
    {
        $user = Auth::user();
        
        $cargos = Funcionario::where([['matricula', '=', $user->matricula]])->first();

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);

        $distribuir = Distribuicao::findOrFail($id);
        $premio = CadastroPremio::findOrFail($distribuir->id_premio);

        $supervisores = Funcionario::where([
            ['matricula_supervisor', '=', $user->matricula],
            ['id_campanha', '=', 26],
            ['ativo', '=', 1 ]
        ])->get();

        return view('premio.sortearSupervisor', ['cargo' => $cargo, 'campanha' => $campanha, 
                    'premio_supervisor' => $distribuir, 'premio' => $premio, 'supervisores' => $supervisores]);
    }

    public function supervisorSorteado(Request $request)
    {       
        $user = Auth::user();
         
        $total_coordenador = Distribuicao::where([['id', '=', $request->id]])->first();

        $coordenador_recebido = $total_coordenador->quantidade_recebida - $request->quantidade;
        $coordenador_distribuido = $total_coordenador->quantidade_distribuida + $request->quantidade;

        Distribuicao::updateOrCreate(['id' => $request->id],
                                     ['quantidade_recebida' => $coordenador_recebido,
                                      'quantidade_distribuida' => $coordenador_distribuido]);
        
        $premio_supervisor = new PremioSupervisor();
        $premio_supervisor->matricula = $request->colaboradores;
        $premio_supervisor->id_premio = $request->id_premio;
        $premio_supervisor->quantidade_recebida = $request->quantidade;
        $premio_supervisor->status_recebimento = 0;
        $premio_supervisor->matricula_coordenador = $user->matricula;
        $premio_supervisor->data_recebida = date('Y-m-d H:i:s');
        $premio_supervisor->premio_coordenador = $request->id;
        $premio_supervisor->save();

        return redirect()->to('dashboard');
    }
}
