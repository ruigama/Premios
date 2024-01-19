@extends('layouts.painel')
@section('title',  'Reiniciar Senha')
@section('content')

<div class="col-md-10 col-sm-12">
    <div class="row">
        <div class="col-md-6 col-sm-12 offset-md-4" id="premio-create-container">
            <form action="/reiniciarSenha" method="post">
                @csrf
                <div class="col-md-12 col-sm-12 form-floating mb-2">                    
                    <select name="users" id="users" class="form-control">
                        <option value="0">Escolha uma opção</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{$user->matricula }} - {{ $user->email }}</option>
                        @endforeach
                    </select>                
                    <label for="users">Escolha o Email</label>
                </div>
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" id="nova_senha" name="nova_senha" placeholder="Nome do Prêmio">
                    <label for="nova_senha" class="py-2">Escolha Nova Senha:</label>
                </div>
                <div class="form-group">
                    <a href="/dashboard" id="botao_voltar" class="btn btn-danger mt-3">Retornar</a>
                    <input type="submit" value="Reiniciar" class="btn btn-primary mt-3" id="btn_reiniciar">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
