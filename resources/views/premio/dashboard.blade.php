@extends('layouts.painel')
@section('title', 'Controle de Prêmios')
@section('content')
    
    <div class="col-md-10 offset-md-1">
    @if($search)
    <h2 class="my-5 text-center">Buscando por: {{ $search }}</h2>
    @else
        @if($msg)
            <p class="msg">{{ $msg }}</p>
        @endif
    <h2 class="my-5 text-center">Premios</h2>
    @endif
        <div class="row">
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="table-dark">
                        <th>#</th>
                        <th>Tipo</th>
                        <th>Quantidade</th>
                        <th>Adicionar</th>
                        <th>Distribuir</th>
                        <th>Editar</th>
                        <th>Limpar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($premio_cadastrado as $item)                            
                    <tr>
                        <td>
                            <img src="{{ asset('img/miniaturas/' . $item->miniatura) }}" alt="Miniatura da Imagem">
                        </td>
                        <td>{{ $item->premio }}</td>
                        <td>{{ $item->quantidade }}</td>
                        <td><a href="/produtos/{{ $item->id }}" class="btn btn-success">Adicionar</a></td>
                        <td><a href="/premio/{{ $item->id }}" class="btn btn-secondary">Distribuir</a></td>
                        <td><a href="/produtos/editar/{{ $item->id }}" class="btn btn-warning">Editar</a></td>
                        <td><a href="/produtos/limpar/{{ $item->id }}" class="btn btn-danger">Limpar</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if(count($premio_cadastrado) == 0 && $search)
                <p>Não foram encontrados {{ $search }} cadastrado. <a href="/">Ver todos</a></p>
            @elseif(count($premio_cadastrado) == 0)
                <p>Não há prêmios cadastrados</p>
            @endif
        </div>
    </div>

@endsection
