@extends('layouts.painel')
@section('title',  'Aceite Supervisor')
@section('content')

<div class="col-md-10 offset-md-1">
    @if($search)
    <h2 class="my-5 text-center">Buscando por: {{ $search }}</h2>
    @else
        @if($msg)
            <p class="alert alert-danger">{{ $msg }}</p>
        @endif
    <h2 class="my-5 text-center">Distribuidos</h2>
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
                        <th class="text-center">Quantidade Pendente</th>
                        <th>Confirmar</th>
                        <th>Cancelar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($itens as $item)                            
                    <tr>
                        <td>
                            <img src="{{ asset('img/miniaturas/' . $item['miniatura']) }}" alt="Miniatura da Imagem">
                        </td>
                        <td>{{ $item['premio'] }}</td>
                        <td class="text-center">{{ $item['quantidade_recebida'] }}</td>
                        <td><a href="/distribuicao/supervisor/confirmar/{{ $item['id'] }}" class="btn btn-success">Confirmar</a></td>
                        <td><a href="/distribuicao/supervisor/cancelar/{{ $item['id'] }}" class="btn btn-danger">Cancelar</a></td>
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
