@extends('layouts.painel')
@section('title', 'Criar Prêmio')
@section('content')

<div id="premio-create-container" class="col-md-6 offset-md-3">
    <h1 class="m-3">Crie uma nova premiação</h1>
    {{-- Form com upload de imagem --}}
    <form action="/premio" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="form-group mb-4 row">
                <label for="image">Imagem:</label>
                <input type="file" id="image" name="image" class="form-control-file">
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="titulo_premio" name="titulo_premio" placeholder="Nome do Prêmio">
                <label for="titulo_premio" class="py-2">Prêmio:</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="descricao_premio" name="descricao_premio" placeholder="Descrição do Prêmio">
                <label for="descricao_premio" class="py-2">Descrição:</label>
            </div>
            <div class="col-md-6 form-floating mb-2">
                <input type="number" class="form-control" id="quantidade_premio" name="quantidade_premio" placeholder="Quantidade">            
                <label for="quantidade_premio" class="py-2">Quantidade:</label>
            </div>
            <div class="form-floating col-md-6 mb-2">
                <input type="date" class="form-control" id="date" name="date">
                <label for="date" class="py-2">Data do cadastro</label>
            </div>
            <div class="form-group">
                <a href="/dashboard" id="botao_voltar" class="btn btn-danger mt-3">Retornar</a>
                <input type="submit" value="Cadastrar Prêmio" class="btn btn-primary mt-3 offset-7">
            </div>
        </div>
    </form>
</div>


@endsection
