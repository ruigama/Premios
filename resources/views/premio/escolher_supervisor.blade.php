@extends('layouts.painel')
@section('title', $premio->premio)
@section('content')
    <div class="col-md-10 offset-md-1">
        <div class="row">
            <div id="image-container" class="col-md-6">
                <img src="/img/premios/{{ $premio->imagem }}" alt="{{ $premio->premio }}" class="image-fluid" style="width: 550px">
            </div>
            <div id="info-container" class="col-md-6">
                <h1>{{ $premio->premio }}</h1>
                <p><ion-icon name="ribbon-outline"></ion-icon> {{ $premio->premio }}</p>
                <p><ion-icon name="receipt-outline"></ion-icon> {{ $premio->descricao }}</p>
                <form action="/distribuicao/supervisor" method="post">
                    @csrf
                    <div class="col-md-10 form-floating mb-2">
                        <input type="hidden" id="id_premio" name="id_premio" value="{{ $premio->id }}">
                        <input type="hidden" id="id" name="id" value="{{ $distribuir->id }}">
                        <input type="hidden" id="total" value="{{ $distribuir->quantidade_recebida }}">

                        <input type="number" class="form-control" id="quantidade" name="quantidade" 
                            placeholder="Distribuir Quantidade" onblur="verificaQuantidade()">
                        <label for="quantidade" class="py-2">Quantidades disponíveis: 
                            <strong>{{ $distribuir->quantidade_recebida }}</strong>
                        </label>
                    </div>
                    <div class="col-md-10 form-floating mb-2">                    
                        <select name="supervisor" id="supervisor" class="form-control">
                            <option value="0">Escolha uma opção</option>
                            @foreach($supervisores as $funcionario)
                                <option value="{{ $funcionario['matricula'] }}">{{ $funcionario['nome'] }}</option>
                            @endforeach
                        </select>                
                        <label for="coordenadores">Escolha o Supervisor</label>
                    </div>
                    <div class="form-group">
                        <a href="/dashboard" id="botao_voltar" class="btn btn-danger mt-3">Retornar</a>
                        <input type="submit" value="Distribuir" class="btn btn-primary mt-3 offset-6" id="btn_distribuir" disabled>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
