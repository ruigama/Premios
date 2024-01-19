@extends('layouts.painel')
@section('title', $premio->premio)
@section('content')
    <div class="col-md-10 col-sm-12 offset-md-1">
        <div class="row">
            <div id="image-container" class="col-md-6 col-sm-12">
                <img src="/img/premios/{{ $premio->imagem }}" alt="{{ $premio->premio }}" class="image-fluid" style="width: 550px">
            </div>
            <div id="info-container" class="col-md-6 col-sm-12">
                <h1>{{ $premio->premio }}</h1>
                <p><ion-icon name="ribbon-outline"></ion-icon> {{ $premio->premio }}</p>
                <p><ion-icon name="receipt-outline"></ion-icon> {{ $premio->descricao }}</p>
                <form action="/distribuicao/supervisorSorteado" method="post">
                    @csrf
                    <div class="col-md-10 col-sm-12 form-floating mb-2">
                        <input type="hidden" id="id_premio" name="id_premio" value="{{ $premio->id }}">
                        <input type="hidden" id="id" name="id" value="{{ $premio_supervisor->id }}">
                        <input type="hidden" id="premio" name="premio" value="{{ $premio_supervisor->id_premio }}">
                        <input type="hidden" id="total" name="total" value="{{ $premio_supervisor->quantidade_recebida }}">

                        <input type="number" class="form-control" id="quantidade" name="quantidade" 
                            placeholder="Distribuir Quantidade" onblur="verificaQuantidade()">
                        <label for="quantidade" class="py-2">Quantidades disponíveis: 
                            <strong>{{ $premio_supervisor->quantidade_recebida }}</strong>
                        </label>
                    </div>
                    <div class="col-md-10 col-sm-12 form-floating mb-2">                    
                        <select name="colaboradores" id="colaboradores" class="form-control">
                            <option value="0">Escolha uma opção</option>
                            @foreach($supervisores as $funcionario)
                                <option value="{{ $funcionario['matricula'] }}">{{ $funcionario['nome'] }}</option>
                            @endforeach
                        </select>                
                        <label for="colaboradores">Escolha o Colaborador</label>
                    </div>
                    <div class="form-group">
                        <a href="/dashboard" id="botao_voltar" class="btn btn-danger mt-3">Retornar</a>
                        <input type="submit" value="Distribuir" class="btn btn-primary mt-3 offset-6" id="btn_distribuir" disabled>
                    </div>
                </form>
            </div>
            {{-- <div class="col-md-10 col-sm-12">
                <h3>Escolha de Colaboradores para sorteio</h3>
                <input onclick="sorteio()" class="btn btn-warning mt-3" id="btnCarregar" value="Carregar" disabled>
            </div>
            <div id="tabelaSortear">
                <table class="table" id="tabela">
                    <thead>
                        <tr>
                            <th scope="col">Escolher</th>
                            <th scope="col">Matricula</th>
                            <th scope="col">Nome</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <button onclick="sortear()" class="btn btn-success mt-3">Sortear</button>
            </div>
            <div id="result"></div>
            <div id="divSorteado">
                <form action="/colaborador/sorteado" method="post">
                    @csrf
                    <input type="hidden" name="matricula_sorteado" id="matricula_sorteado">
                    <input type="hidden" name="id_sorteado" id="id_sorteado">
                    <input type="submit" value="Confirmar" class="btn btn-primary mt-3 offset-5" id="confirmar_sorteio" >
                </form>
            </div>

            <div class="col-md-10 col-sm-12 my-5 offset-md-1" id="divEscolher">
            </div>

            <div class="popup" id="popup">
                <div class="popup-inner">
                    <p id="popup-text">O item sorteado foi: </p>
                    <h1 id="popup-item"></h1>
                    <span class="popup-close" onclick="fecharPopup()">x</span>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
