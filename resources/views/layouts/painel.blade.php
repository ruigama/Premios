<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <title>@yield('title')</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/dashboard/">

    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <meta name="theme-color" content="#712cf9">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
      /* #info-container ion-icon
        {
            font-size: 20px;
            color: #de19f0;
            margin-right: 5px;
        } */

        
    </style>

    
    <!-- Custom styles for this template -->
    <link href="/css/dashboard.css" rel="stylesheet">
    <link href="/css/styles.css" rel="stylesheet">
    <script src="/js/scripts.js" async></script>
    <script src="/js/graficos.js" async></script>
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
    <script src="/js/jquery.easing.1.3.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.min.js"></script>
  </head>
  <body onload="document.getElementById('tabelaSortear').style.display='none'; document.getElementById('divSorteado').style.display='none';">
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow ">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="/dashboard">
        <img src="/img/winover.png" style="width: 80px;" alt="">
    </a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <form action="/dashboard" method="get" class="col-md-5  offset-md-0">
        <input type="text" name="search" id="search" class="form-control form-control-dark rounded-0 border-0" 
                placeholder="Procurar...">
    </form>
    <ul class="nav">
        @auth
        @if($cargo <> 2)
        @if($campanha == 29)
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/premio/criar">
            <span data-feather="home" class="align-text-bottom"></span>
            Cadastrar
            <ion-icon name="create-outline"></ion-icon>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/dashboard">
            <span data-feather="file" class="align-text-bottom"></span>
            Consultar
            <ion-icon name="search-outline"></ion-icon>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/graficos">
            <span data-feather="shopping-cart" class="align-text-bottom"></span>
            Totais
            <ion-icon name="cart-outline"></ion-icon>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/atualizarSenha">
            <span data-feather="shopping-cart" class="align-text-bottom"></span>
            Atualizar Senha
            <ion-icon name="key-outline"></ion-icon>
          </a>
        </li>
        @endif
        @if($campanha == 26 || $campanha == 30 || $campanha == 59)
        <li class="nav-item">
          <a class="nav-link" href="/atualizarSenha">
            <span data-feather="shopping-cart" class="align-text-bottom"></span>
            Atualizar Senha
            <ion-icon name="key-outline"></ion-icon>
          </a>
        </li>
        @endif
      @endif
        @endauth
        </ul>
    <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <form action="/logout" method="post">
                @csrf
                <li class="nav-item">                
                    <a href="/logout" class="nav-link px-5" onclick="event.preventDefault();
                        this.closest('form').submit();">Sair<ion-icon name="log-in-sharp" style="margin-left: 5px">
                    </a>                        
                </li>
            </form>
        </div>
    </div>
</header>

<div class="container-fluid">
    <main>
        <div class="container-fluid">
            <div class="row">
                @if(session('msg'))
                <p class="msg">{{ session('msg') }}</p>
                @endif
                @yield('content')
            </div>
        </div>
    </main>
    {{-- <footer>
      <p>Controle de Prêmios &copy; 2023</p>
    </footer> --}}
</div>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    

    {{-- <script src="/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> --}}
    
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>{{-- <script src="dashboard.js"></script> --}}
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
   
  </body>
</html>
