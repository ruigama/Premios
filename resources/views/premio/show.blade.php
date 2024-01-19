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
                <p><ion-icon name="ribbon-outline"></ion-icon> {{ $premio->quantidade }}</p>
                <p><ion-icon name="ribbon-outline"></ion-icon> {{ $premio->premio }}</p>
                <p><ion-icon name="receipt-outline"></ion-icon> {{ $premio->descricao }}</p>
                <p ><ion-icon name="receipt-outline"></ion-icon> {{ $premio->quantidade }}</p>
                <form action="/distribuicao/coordenador" method="post">
                    @csrf
                    <div class="col-md-10 form-floating mb-2">
                        <input type="hidden" id="id_premio" name="id_premio" value="{{ $premio->id }}">
                        <input type="hidden" id="total" value="{{ $premio->quantidade }}">

                        <input type="number" class="form-control" id="quantidade" name="quantidade" 
                            placeholder="Distribuir Quantidade" onblur="verificaQuantidade()">
                        <label for="quantidade" class="py-2">Quantidades disponíveis: 
                            <strong>{{ $premio->quantidade }}</strong>
                        </label>
                    </div>
                    <div class="col-md-10 form-floating mb-2">                    
                        <select name="coordenadores" id="coordenadores" class="form-control">
                            <option value="0">Escolha uma opção</option>
                            @foreach($funcionarios as $funcionario)
                                <option value="{{ $funcionario['matricula'] }}">{{ $funcionario['nome'] }}</option>
                            @endforeach
                        </select>                
                        <label for="coordenadores">Escolha o Coordenador</label>
                    </div>
                    <div class="form-group">
                        <a href="/dashboard" id="botao_voltar" class="btn btn-danger mt-3">Retornar</a>
                        <input type="submit" value="Distribuir" class="btn btn-primary mt-3 offset-6" id="btn_distribuir" disabled>
                    </div>
                </form>
            </div>
        </div>
        {{-- <body>
            <h1>Roleta de Prêmios</h1>
            <p>Prêmio:</p>
            <p id="premio"></p>
            <button onclick="girarRoleta()">Veja o seu prêmio</button>
            <link rel="stylesheet" href="style.css" type="text/css">
        </body>
          
        <script>
            var premios = [
                "iPhone",
                "iPad",
                "Máquina de café",
                "Fone de ouvido",
                "Camiseta",
                "Mousepad",
                "Caneca"
            ];
            
            function escolherPremio() {
              return premios[Math.floor(Math.random() * premios.length)];
            }
          
            function girarRoleta() {
              var duracao = 3000; // 3 segundos
              var intervalo = 50; // 50 milissegundos por frame
              var rotacoes = duracao / intervalo;
              var premio = null;
              var contador = 0;
            
              var id = setInterval(function() {
                contador++;
                premio = escolherPremio();
                document.getElementById("premio").innerHTML = premio;
                
            
                if (contador >= rotacoes) 
                {
                    document.getElementById("premio").innerHTML = "";
                    clearInterval(id);
                    alert("Seu prêmio foi sorteado, clique para ver !");
                    document.getElementById("premio").innerHTML = premio;                  
                }
              }, intervalo);
            }
          
          </script> --}}
    </div>
@endsection
