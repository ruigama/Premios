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

class GraficoController extends Controller
{
    public function grafico()
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

        return view('premio.grafico', ['cargo' => $cargo, 'campanha' => $campanha]);
    }

    public function totalCadastrado()
    {
        $totais = CadastroPremio::All();

        $resultado = array();

        foreach($totais as $total)
        {
            $array = array(
                "premio" => htmlentities($total->premio),
                "quantidade" => htmlentities($total->quantidade),
                "total_cadastrado" => htmlentities($total->total_cadastrado)
            );

            $resultado[] = $array;
        }

        return response($resultado);
    }

    public function totalCoordenador()
    {
        $totais = Distribuicao::All();

        $resultado = array();

        foreach($totais as $total)
        {
            $matricula_coordenador = Funcionario::where([['matricula', '=', $total->matricula_coordenador]])->first();
            $array = array(
                "matricula_coordenador" => htmlentities($total->matricula_coordenador),
                "nome_coordenador" => htmlentities($matricula_coordenador->nome),
                "disponivel" => htmlentities($total->quantidade_recebida),
                "distribuido" => htmlentities($total->quantidade_distribuida),
                "total_recebido" => htmlentities($total->total_recebido)
            );

            $resultado[] = $array;
        }

        return response($resultado);
    }

    public function totalSupervisor()
    {
        $totais = Supervisor::join('cadastro_premios', 'premios_supervisor.id_premio', '=', 'cadastro_premios.id')
        ->select('cadastro_premios.*', 'premios_supervisor.*')->get();

        $resultado = array();

        foreach($totais as $total)
        {
            $matricula_supervisor = htmlentities($total->matricula_supervisor);
            $nome_supervisor = Funcionario::where([['matricula', '=', $matricula_supervisor]])->first();
            $array = array(
                "matricula_supervisor" => htmlentities($total->matricula_supervisor),
                "nome_supervisor" => htmlentities($nome_supervisor->nome),
                "premio" => htmlentities($total->premio),
                "disponivel" => htmlentities($total->disponivel),
                "distribuido" => htmlentities($total->distribuido)
            );

            $resultado[] = $array;
        }

        return response($resultado);
    }

    public function contagemCoordenador()
    {
        
    }
}
