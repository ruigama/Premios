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

class ColaboradorController extends Controller
{
    public function confirmarRecebimento($id)
    {
        $user = Auth::user();
        $msg = '';
        
        $cargos = Funcionario::where([['matricula', '=', $user->matricula]])->first();

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);

        $premio_colaborador = Colaborador::findOrFail($id);

        $premio_colaborador->status_recebimento = 1;

        $atualizado = Colaborador::updateOrCreate(['id' => $premio_colaborador->id],
                                                  ['status_recebimento' => $premio_colaborador->status_recebimento]);
        
        if($atualizado)
        {
            $msg = 'Premio confirmado com sucesso';
            return redirect()->to('/dashboard')->with(['premio_cadastrado' => $atualizado, 
                                                       'cargo' => $cargo, 'campanha' => $campanha, 'msg' => $msg]);
        }
    }

    public function colaboradorSorteado(Request $request)
    {
        $user = Auth::user();
        $msg = '';
        
        $cargos = Funcionario::where([
            ['matricula', '=', $user->matricula]
        ])->first();

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);

        $id = $request->id_sorteado;

        $premio_supervisor = Supervisor::findOrFail($id);
        $supervisor = new Supervisor();

        $disponivel_supervisor = htmlentities($premio_supervisor->disponivel);
        $distribuido_supervisor = htmlentities($premio_supervisor->distribuido);
        $matricula_supervisor = $premio_supervisor->matricula_supervisor;
        $supervisor->id = $premio_supervisor->id;
        $supervisor->matricula_supervisor = $premio_supervisor->matricula_supervisor;
        $supervisor->id_premio = $premio_supervisor->id_premio;
        $supervisor->disponivel = $disponivel_supervisor - 1;
        $supervisor->distribuido = $distribuido_supervisor + 1;

        $supervisor_atualizado = Supervisor::updateOrCreate(['id' => $supervisor->id],
                                                            ['matricula_supervisor' => $supervisor->matricula_supervisor,
                                                             'id_premio' => $supervisor->id_premio,
                                                             'disponivel' => $supervisor->disponivel,
                                                             'distribuido' => $supervisor->distribuido]);
                                                
        $matricula_colaborador = $request->matricula_sorteado;
        $matricula_separada = explode(" ", $matricula_colaborador);

        $colaborador = new Colaborador();
        $colaborador->matricula = $matricula_separada[0];
        $colaborador->id_premio = $supervisor->id_premio;
        $colaborador->quantidade_recebida = 1;
        $colaborador->status_recebimento = 0;
        $colaborador->matricula_supervisor = $matricula_supervisor;
        $colaborador->data_recebida = date('Y-m-d H:i:s');

        $colaborador->save();

        return redirect()->to('/dashboard')->with(['cargo' => $cargo, 'campanha' => $campanha, 'msg' => $msg]);
    }
}
