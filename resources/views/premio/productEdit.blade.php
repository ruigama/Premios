@extends('layouts.painel')
@section('title',  'Produtos')
@section('content')

<div id="premio-create-container" class="col-md-6 offset-md-3">
    <h1 class="m-3">Redefinir Quantidade do Produto</h1>
    <form action="/premio/atualizarContagem" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="form-floating mb-2">
                <input type="hidden" name="id_premio" value="{{ $premio->id }}">
                <input type="text" class="form-control" id="titulo_premio" name="titulo_premio" 
                       placeholder="Nome do Prêmio {{ $premio->premio }}" value="{{ $premio->premio }}" disabled>
                <label for="titulo_premio" class="py-2">{{ $premio->premio }}</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="descricao_premio" name="descricao_premio" 
                       placeholder="{{ $premio->descricao }}" value="{{ $premio->descricao }}" disabled>
                <label for="descricao_premio" class="py-2">{{ $premio->descricao }}</label>
            </div>
            <div class="col-md-6 form-floating mb-2">
                <input type="number" class="form-control" id="quantidade_premio" name="quantidade_premio" 
                       placeholder="Quantidade" onblur="quantidadeProduto()">            
                <label for="" class="py-2">Quantidade atual: {{ $premio->quantidade }}</label>
            </div>
            <div class="form-floating col-md-6 mb-2">
                <input type="date" class="form-control" id="date" name="date">
                <label for="date" class="py-2">Ultima atualização: {{ date('d/m/Y'), strtotime($premio->date) }} </label>
            </div>
            {{-- <div class="alert alert-warning d-flex align-items-center" role="alert">                
                <div>
                    <ion-icon name="warning-outline"></ion-icon>
                    
                </div>
            </div> --}}
            <div class="form-group">
                <a href="/dashboard" id="botao_voltar" class="btn btn-danger mr-3 align-self-end">Retornar</a>
                <input type="submit" value="Atualizar Quantidade" id="btn_atulizar_qtd" 
                        class="btn btn-primary m-3" onclick="carregando()" disabled>
            </div>
        </div>
    </form>
</div>

@endsection
