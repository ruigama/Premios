@extends('layouts.main')
@section('title', 'Controle de Prêmios')
@section('content')

<div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1>Prêmios cadastrados</h1>    
</div>
<div class="col-md-10 offset-md-1 dashboard-title-container">
    @if(count($premios) > 0)
    @else
        <h1>Você não tem premios cadastrados</h1>
    @endif
</div>

@endsection
