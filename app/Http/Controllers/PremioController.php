<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CadastroPremio;
use App\Models\Funcionario;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class PremioController extends Controller
{
    public function index(Request $request)
    {
        $search = request('search');

        if($search)
        {
            $premio_cadastrado = CadastroPremio::where([['premio', 'like', '%'.$search.'%']])->get();
            $user = Auth::user();
        }
        else
        {
            $premio_cadastrado = CadastroPremio::All();
            $user = Auth::user();
        }

        return view('welcome', ['premio_cadastrado' => $premio_cadastrado, 'search' => $search, 'name' => $user]);
    }

    public function create()
    {
        $user = Auth::user();
        $cargos = Funcionario::where([
            ['matricula', '=', $user->matricula]
        ])->first();

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);

        return view('premio.create', ['cargo' => $cargo, 'campanha' => $campanha]);
    }

    public function store(Request $request)
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

        $premio = new CadastroPremio;
        $premio->premio = strtoupper($request->titulo_premio);
        $premio->descricao = $request->descricao_premio;
        $premio->item = 0;
        $premio->date = $request->date;
        $premio->quantidade = $request->quantidade_premio;
        $premio->total_cadastrado = $request->quantidade_premio;

        if($request->hasfile('image') && $request->file('image')->isValid())
        {
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('img/premios'), $imageName);

            $miniatura = Image::make(public_path('img/premios/' . $imageName))->fit(50, 50);
            $miniatura->save(public_path('img/miniaturas/' . $imageName));

            $premio->imagem = $imageName;
            $premio->miniatura = $imageName;
        }

        $premio->save();

        $premio_cadastrado = CadastroPremio::where([['premio', 'like', '%'.$search.'%']])->get();
        
        $msg = "Produto cadastrado com sucesso!";

        return redirect()->to('/dashboard')->with(['premio_cadastrado' => $premio_cadastrado, 'search' => $search, 
                    'cargo' => $cargo, 'campanha' => $campanha, 'msg' => $msg]);
    }

    public function show($id)
    {
        $funcionarios = [];
        $msg = "";
        $user = Auth::user();
        $cargos = Funcionario::where([['matricula', '=', $user->matricula]])->first();
        $id_campanha = [30,59];

        $operadores = Funcionario::whereIn('id_campanha', $id_campanha)->get();

        foreach ($operadores as $operador) 
        {
            $operadorData = [
                'matricula' => htmlspecialchars($operador->matricula),
                'nome' => htmlspecialchars($operador->nome),
                'id_campanha' => htmlspecialchars(($operador->id_campanha))
            ];

            $funcionarios[] = $operadorData;
        }

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);

        $premio = CadastroPremio::findOrFail($id);
        return view("premio.show", ['premio' => $premio, 'cargo' => $cargo, 'campanha' => $campanha, 
                    'msg' => $msg, 'funcionarios' => $funcionarios]);
    }

    public function product($id)
    {
        $user = Auth::user();
        $cargos = Funcionario::where([['matricula', '=', $user->matricula]])->first();

        $premio = CadastroPremio::findOrFail($id);

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);

        return view('premio.product', ['cargo' => $cargo, 'campanha' => $campanha, 'premio' => $premio]);
    }

    public function update(Request $request)
    {
        $search = request('search');
        $user = Auth::user();
        $cargos = Funcionario::where([
            ['matricula', '=', $user->matricula]
        ])->first();

        $msg = null;

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);

        $premio_atual = CadastroPremio::where([
            ['id', '=', $request->id_premio]
        ])->first();

        $premio_titulo = htmlentities($premio_atual->premio);
        $quantidade_antiga = htmlentities($premio_atual->quantidade);
        $quantidade_total = htmlentities($premio_atual->total_cadastrado);
        $quantidade_inserida = $request->quantidade_premio;
        $quantidade_inserida = intval($quantidade_inserida);
        $quantidade_total = intval($quantidade_total);
        $quantidade_atualizada = $quantidade_antiga + $quantidade_inserida;
        $total_atualizado = $quantidade_total + $quantidade_inserida;


        $atualizar_premio = new CadastroPremio();
        $atualizar_premio->id = $request->id_premio;
        $atualizar_premio->quantidade = $quantidade_atualizada;
        $atualizar_premio->total_cadastrado = $total_atualizado;
        $atualizar_premio->date = $request->date;

        $atualizado = CadastroPremio::updateOrCreate(['id' => $atualizar_premio->id], 
                                                     ['quantidade' => $atualizar_premio->quantidade,
                                                      'total_cadastrado' => $atualizar_premio->total_cadastrado]);
        
        if($atualizado)
        {
            $msg = "Quantidade do produto ".$premio_titulo." atualizado com sucesso!";
        }
        
        $premio_cadastrado = CadastroPremio::All();

        return redirect()->to('/dashboard')->with(['premio_cadastrado' => $premio_cadastrado, 'search' => $search, 
                    'cargo' => $cargo, 'campanha' => $campanha, 'msg' => $msg]);
    }
    
    public function productEdit($id)
    {
        $user = Auth::user();
        $cargos = Funcionario::where([['matricula', '=', $user->matricula]])->first();

        $premio = CadastroPremio::findOrFail($id);

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);

        return view('premio.productEdit', ['cargo' => $cargo, 'campanha' => $campanha, 'premio' => $premio]);
    }

    public function zerarValores($id)
    {
        $user = Auth::user();
        $cargos = Funcionario::where([['matricula', '=', $user->matricula]])->first();

        $premio = CadastroPremio::findOrFail($id);

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);

        return view('premio.zerarProduto', ['cargo' => $cargo, 'campanha' => $campanha, 'premio' => $premio]);
    }

    public function atualizarContagem(Request $request)
    {
        $user = Auth::user();
        $cargos = Funcionario::where([['matricula', '=', $user->matricula]])->first();

        $premio_atual = CadastroPremio::where([['id', '=', $request->id_premio]])->first();

        //dd($premio_atual);
        $total_cadastrado_atual = $premio_atual->total_cadastrado;
        $quantidade_atual = $premio->quantidade;
        $novo_total = $total_cadastrado_atual - $quantidade_atual;
        $nova_quantidade = $request->quantidade;
        $novo_total_cadastrado = $novo_total + $nova_quantidade;

        $atualizar_premio = new CadastroPremio();
        $atualizar_premio->id = $request->id_premio;
        $atualizar_premio->quantidade = $nova_quantidade;
        $atualizar_premio->total_cadastrado = $novo_total_cadastrado;
        $atualizar_premio->date = $request->date;

        $atualizado = CadastroPremio::updateOrCreate(['id' => $atualizar_premio->id], 
                                                     ['quantidade' => $atualizar_premio->quantidade,
                                                      'total_cadastrado' => $atualizar_premio->total_cadastrado,
                                                      'date' => $atualizar_premio->date]);

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);

        return redirect()->to('/dashboard')->with(['premio_cadastrado' => $premio_cadastrado, 'search' => $search, 
                    'cargo' => $cargo, 'campanha' => $campanha, 'msg' => $msg]);
    }

    public function zerarContagem(Request $request)
    {
        $user = Auth::user();
        $cargos = Funcionario::where([['matricula', '=', $user->matricula]])->first();

        $premio = CadastroPremio::findOrFail($id);

        $value_cargo = $cargos->id_cargo;
        $value_campanha = $cargos->id_campanha;
        $cargo = htmlspecialchars($value_cargo);
        $campanha = htmlspecialchars($value_campanha);

        return redirect()->to('/dashboard')->with(['premio_cadastrado' => $premio_cadastrado, 'search' => $search, 
                    'cargo' => $cargo, 'campanha' => $campanha, 'msg' => $msg]);
    }
}
