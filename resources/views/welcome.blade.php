@extends('layouts.main')
@section('title', 'Controle de Prêmios')
@section('content')

<div id="search-container" class="col-md-12 container">
    <h1>Busque um Prêmio</h1>
    <form action="/verificar" method="post">
        @csrf
        <input type="text" name="search" id="search" class="form-control" placeholder="Procurar...">
    </form>
</div>
<div id="premio-container" class="col-md-12 container">
    @if($search)
    <h2>Buscando por: {{ $search }}</h2>
    @else
    <h2>Premios</h2>
    @endif
    <div id="cards-container" class="row">
        {{-- @foreach($premio_cadastrado as $premio)
            <div class="card col-md-3">
                <img src="/img/premios/{{ $premio->imagem }}" alt="{{ $premio->$premio }}">
                <div class="card-body">
                    <p class="card-date">{{ date('d/m/Y'), strtotime($premio->date) }}</p>
                    <h5 class="card-title">{{ $premio->premio }}</h5>
                    <p>{{ $premio->descricao }}</p>
                    <a href="/premio/{{ $premio->id }}" class="btn btn-primary">Visualizar</a>
                </div>
            </div>
        @endforeach --}}
        {{-- @if(count($premio_cadastrado) == 0 && $search)
            <p>Não foram encontrados {{ $search }} cadastrado. <a href="/">Ver todos</a></p>
        @elseif(count($premio_cadastrado) == 0)
            <p>Não há prêmios cadastrados</p>
        @endif --}}
    </div>
</div>

@endsection
