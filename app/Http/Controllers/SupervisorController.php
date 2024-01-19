<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CadastroPremio;
use App\Models\Funcionario;
use App\Models\Distribuicao;
use App\Models\Premio;
use App\Models\Supervisor;
use App\Models\Colaborador;

class SupervisorController extends Controller
{
    public function distribuicaoColaborador($id)
    {
        $search = request('search');
        $user = Auth::user();

        $cargos = Funcionario::where([
            ['matricula', '=', $user->matricula]
        ])->first();

        $colaboradores = Funcionario::where([['matricula_supervisor', '=', $user->matricula],
                                             ['ativo', '=', 1]])->get();

        $premio_supervisor = Supervisor::where([['id', '=', $id]])->first();
        $premio_atual = CadastroPremio::where([['id', '=', $premio_supervisor->id_premio]])->first();

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);

        $itens = [];

        foreach($colaboradores as $colaborador)
        {
            $itemData = [
                "matricula" => htmlentities($colaborador->matricula),
                "nome" => htmlentities($colaborador->nome)
            ];

            $itens[] = $itemData;
        }

        $array_colaboradores = json_encode($itens);
        //dd($itens);


        return view('premio.escolher_colaborador', ['cargo' => $cargo, 'campanha' => $campanha, 
                    'premio_supervisor' => $premio_supervisor, 'premio' => $premio_atual, 
                    'colaboradores' => $colaboradores, 'array_colaboradores' => $array_colaboradores]);
    }

    public function enviarColaborador(Request $request)
    {
        $search = request('search');
        $user = Auth::user();

        $cargos = Funcionario::where([
            ['matricula', '=', $user->matricula]
        ])->first();

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);

        $id_premio = $request->id_premio;
        $supervisor_id_premio = $request->id;
        $supervisor_disponivel = $request->total;
        $distribuido = $request->quantidade;
        $novo_total = $supervisor_disponivel - $distribuido;
        $colaborador = $request->colaboradores;

        $premio_atual_supervisor = Supervisor::where([['id', '=', $supervisor_id_premio]])->first();        
        $premio_atual_supervisor->id = $supervisor_id_premio;
        $premio_atual_supervisor->disponivel = $novo_total;
        $premio_atual_supervisor->distribuido = $distribuido;
        
        $colaborador = new Colaborador();
        $colaborador->matricula = $request->colaboradores;
        $colaborador->id_premio = $id_premio;
        $colaborador->quantidade_recebida = $distribuido;
        $colaborador->status_recebimento = 0;
        $colaborador->matricula_supervisor = $user->matricula;
        $colaborador->data_recebida = date('Y-m-d H:i:s');

        if($colaborador->save())
        {
            $msg = "Premio distribuido com sucesso para a matrícula ".$request->colaboradores."!";
            
            $criado = Supervisor::updateOrCreate(['id' => $premio_atual_supervisor->id],
                                                 ['disponivel' => $premio_atual_supervisor->disponivel,
                                                  'distribuido' => $premio_atual_supervisor->distribuido]);
        }

        $premio_cadastrado = Supervisor::where([['matricula_supervisor', '=', $user->matricula]])->get();


        return redirect()->to('/dashboard')->with(['search' => $search, 'premio_cadastrado' => $premio_cadastrado,
                'cargo' => $cargo, 'campanha' => $campanha, 'msg' => $msg]);
    }

    public function supervisorAceitar($id)
    {
        $aceito = PremioSupervisor::updateOrCreate(['id' => $id],['status_recebimento' => 1]);

        return redirect()->to('/dashboard');
    }

    public function supervisorCancelar($id)
    {
        $premio_supervisor = PremioSupervisor::where([['id', '=', $id]])->first();
        $coordenador = Distribuicao::where([['id', '=', $premio_supervisor->premio_coordenador]])->first();
        
        $atualizar_coordenador = new Distribuicao();
        $atualizar_coordenador->id = $premio_supervisor->premio_coordenador;
        $atualizar_coordenador->quantidade_recebida = $coordenador->quantidade_recebida + $premio_supervisor->quantidade_recebida;
        $atualizar_coordenador->quantidade_distribuida = $coordenador->quantidade_distribuida - $premio_supervisor->quantidade_recebida;
        $atualizado = Distribuicao::updateOrCreate(['id' => $atualizar_coordenador->id],
                                                   ['quantidade_recebida' => $atualizar_coordenador->quantidade_recebida,
                                                    'quantidade_distribuida' => $atualizar_coordenador->quantidade_distribuida]);

        $nao_aceito = PremioSupervisor::updateOrCreate(['id' => $id],['status_recebimento' => 2]);

        return redirect()->to('/dashboard');
        
    }
}
