<!DOCTYPE html>
<html>
<head>
    <title>Recebimento do prêmio {{ $premio->premio }}</title>
</head>
<body>
    <h1>Prêmio Cadastrado: {{ $premio->premio }}</h1>
    <p>Olá {{ $user->name }},</p>
    <p>Você recebeu um novo prêmio: {{ $premio->premio }}</p>
    <p>Descrição: {{ $premio->descricao }}</p>
    <p>Quantidade: {{ $quantidade }}</p>
    <p>Parabéns!</p>
    <p>Atenciosamente,</p>
    <p>A Equipe da Sua Aplicação</p>
</body>
</html>