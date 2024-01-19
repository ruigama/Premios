@extends('layouts.painel')
@section('title', 'No Content')
@section('content')

<div class="col-md-10 offset-md-1 dashboard-title-container">
    <div class="alert alert-danger">
        Não há nada disponível, clique em sair da aplicação!
    </div>
    <form action="/logout" method="post">
        @csrf                
            <a href="/logout" class="btn btn-danger" onclick="event.preventDefault();
                this.closest('form').submit();">Sair<ion-icon name="log-in-sharp" style="margin-left: 5px">
            </a> 
    </form>   
</div>

@endsection
