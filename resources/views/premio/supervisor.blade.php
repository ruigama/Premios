@extends('layouts.painel')
@section('title',  'Produtos')
@section('content')

<div class="col-md-10 offset-md-1">
    @if($search)
    <h2 class="my-5 text-center">Buscando por: {{ $search }}</h2>
    @else
        @if($msg)
            <p class="msg">{{ $msg }}</p>
        @endif
    <h2 class="my-5 text-center">Premios Disponíveis</h2>
    @endif
    <div class="row">
        <div class="md-10">
            @if(count($itens) == 0)
            <p>Não há prêmios cadastrados</p>
            @elseif(count($itens) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipo</th>
                        <th>Quantidade</th>
                        <th>Distribuidos</th>
                        <th>Distribuir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($itens as $item)                            
                    <tr>
                        <td>
                            <img src="{{ asset('img/miniaturas/' . $item['miniatura']) }}" alt="Miniatura da Imagem">
                        </td>
                        <td>{{ $item['premio'] }}</td>
                        <td>{{ $item['disponivel'] }}</td>
                        <td>{{ $item['distribuido'] }}</td>
                        <td><a href="/distribuicao/colaborador/{{ $item['id'] }}" class="btn btn-success">Distribuir</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
                
        </div>
        @elseif(count($itens) == 0 && $search)
            <p>Não foram encontrados {{ $search }} cadastrado. <a href="/">Ver todos</a></p>
        @endif
    </div>
</div>
@endsection
