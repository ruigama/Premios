<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;
use App\Models\CadastroPremio;
use App\Models\Distribuicao;
use App\Models\Supervisor;
use App\Models\Colaborador;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use stdClass;

class FuncionarioController extends Controller
{
    public function index()
    {
        $search = request('search');
        $msg = null;
        return view('welcome', ['search' => $search, 'msg' => $msg]);
    }
    
    public function dashboard()
    {
        $search = request('search');
        $msg = null;

        $user = Auth::user();

        $cargos = Funcionario::where([['matricula', '=', $user->matricula]])->first();

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);
        
        if($search)
        {
            $premio_cadastrado = CadastroPremio::where([['premio', 'like', '%'.$search.'%']])->get();            
        }
        else
        {
            $premio_cadastrado = CadastroPremio::All();            
        }

        if($campanha == 29)
        {
            return view('premio.dashboard', ['premio_cadastrado' => $premio_cadastrado, 'search' => $search, 
                    'cargo' => $cargo, 'campanha' => $campanha, 'msg' => $msg]);
        }
        else if($campanha == 30 || $campanha == 59)
        {   
            $status_distribuicao = Distribuicao::where([
                ['matricula_coordenador', '=', $user->matricula],
                ['status_recebimento', '=', 0]
            ])->get();

            if(count($status_distribuicao) > 0)
            {
                $itens = [];
                    
                foreach ($status_distribuicao as $item) 
                {
                    $relacionado = CadastroPremio::where('id', $item->id_premio)->first();
                    
                    $itemData = [
                        'id' => htmlentities($item->id),
                        'id_premio' => htmlentities($item->id_premio),
                        'matricula_coordenador' => htmlentities($item->matricula_coordenador),
                        'quantidade_recebida' => htmlentities($item->quantidade_recebida),
                        'quantidade_distribuida' => htmlentities($item->quantidade_distribuida),
                        'premio' => htmlentities($relacionado->premio),
                        "miniatura" => htmlentities($relacionado->miniatura),
                        "quantidade_temporaria" => htmlentities($item->quantidade_temporaria),
                    ];                
                    
                    $itens[] = $itemData; 
                }
                
                $msg = "Você tem prêmios para confirmar o recebimento!";

                return view('premio.coordenador_aceite', ['itens' => $itens, 'search' => $search, 
                    'cargo' => $cargo, 'campanha' => $campanha, 'msg' => $msg]);
            }
            else
            {
                $distribuicao = Distribuicao::where([
                    ['matricula_coordenador', $user->matricula],
                    ['status_recebimento', '=', 1]
                    ])->get();
                
                $itens = [];
                
                foreach ($distribuicao as $item) 
                {
                    $relacionado = CadastroPremio::where('id', $item->id_premio)->first();
                    
                    $itemData = [
                        'id' => htmlentities($item->id),
                        'id_premio' => htmlentities($item->id_premio),
                        'matricula_coordenador' => htmlentities($item->matricula_coordenador),
                        'quantidade_recebida' => htmlentities($item->quantidade_recebida),
                        'quantidade_distribuida' => htmlentities($item->quantidade_distribuida),
                        'premio' => htmlentities($relacionado->premio),
                        "miniatura" => htmlentities($relacionado->miniatura)
                    ];                
                    
                    $itens[] = $itemData; 
                }
                
                return view('premio.coordenador', ['itens' => $itens, 'search' => $search, 
                'cargo' => $cargo, 'campanha' => $campanha, 'msg' => $msg]);
            }
        }
        else if($campanha == 26)
        {
            $supervisor = Supervisor::where('matricula_supervisor', $user->matricula)->get();

            $itens = [];

            foreach ($supervisor as $item) 
            {
                $relacionado = CadastroPremio::where('id', $item->id_premio)->first();

                $itemData = [
                    'id' => htmlentities($item->id),
                    'id_premio' => htmlentities($item->id_premio),
                    'matricula_supervisor' => htmlentities($item->matricula_supervisor),
                    'disponivel' => htmlentities($item->disponivel),
                    'distribuido' => htmlentities($item->distribuido),
                    'premio' => htmlentities($relacionado->premio),
                    'miniatura' => htmlentities($relacionado->miniatura)
                ];                

                $itens[] = $itemData; 
            }
            return view('premio.supervisor', ['itens' => $itens, 'search' => $search, 
                        'cargo' => $cargo, 'campanha' => $campanha, 'msg' => $msg]);
        }

        else if($cargo == 2)
        {
            $colaborador = Colaborador::where([
                ['matricula', $user->matricula],
                ['status_recebimento', '=', 0]])->get();

            $itens = [];

            foreach ($colaborador as $item) 
            {
                $relacionado = CadastroPremio::where('id', $item->id_premio)->first();

                $itemData = [
                    'id' => htmlentities($item->id),
                    'id_premio' => htmlentities($item->id_premio),
                    'matricula_supervisor' => htmlentities($item->matricula_supervisor),
                    'quantidade_recebida' => htmlentities($item->quantidade_recebida),
                    'status_recebimento' => htmlentities($item->status_recebimento),
                    'data_recebida' => htmlentities($item->data_recebida),
                    'premio' => htmlentities($relacionado->premio),
                    'miniatura' => htmlentities($relacionado->miniatura)
                ];                

                $itens[] = $itemData; 
            }

            return view('premio.colaborador', ['cargo' => $cargo, 'campanha' => $campanha, 'msg' => $msg, 
                        'itens' => $itens, 'search' => $search]);
        }
        else
        {
            return view('noContent', ['cargo' => $cargo, 'campanha' => $campanha, 'msg' => $msg, 
                        'search' => $search]);
        }
    }

    public function sorteio()
    {
        $user = Auth::user();
        $colaboradores = Funcionario::where([
            ["matricula_supervisor", "=", $user->matricula],
            ['ativo', '=', 1]
            ])->get();
        
        $resultado = array();

        foreach($colaboradores as $colaborador)
        {
            $array = array(
                "matricula" => htmlentities($colaborador->matricula),
                "nome" => htmlentities($colaborador->nome)
            );

            $resultado[] = $array;
        }

        //$json = json_encode($resultado);

        return response($resultado);        
    }

    public function atualizarSenha()
    {
        $search = request('search');
        $msg = null;

        $user = Auth::user();
        $excluido = [$user->matricula, 2885];

        $usuarios = User::whereNotIn('matricula', $excluido)->orderBy('matricula', 'asc')->get();
        
        $cargos = Funcionario::where([['matricula', '=', $user->matricula]])->first();

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);



        return view('premio.atualizar_senha', ['search' => $search, 
                    'cargo' => $cargo, 'campanha' => $campanha, 'msg' => $msg, 'users' => $usuarios]);
    }

    public function reiniciarSenha(Request $request)
    {
        $senha = $request->nova_senha;
        
        $hashed_senha = bcrypt($senha);

        $salvo = User::updateOrCreate(['id' => $request->users], ['password' => $hashed_senha]);

        $msg = null;

        if($salvo)
        {
            $msg = "Senha atualizada com sucesso!";
        }

        $search = request('search');

        $user = Auth::user();

        $cargos = Funcionario::where([['matricula', '=', $user->matricula]])->first();
        $premio_cadastrado = CadastroPremio::All();

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);

        return redirect()->to('/dashboard')->with(['premio_cadastrado' => $premio_cadastrado, 'search' => $search, 
                'cargo' => $cargo, 'campanha' => $campanha, 'msg' => $msg]);
    }
}
