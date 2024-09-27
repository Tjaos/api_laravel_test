<!DOCTYPE html>
<html>
<head>
    <title>Produto Cadastrado com Sucesso</title>
</head>
<body>
<h1>Olá {{ $product->user ? $product->user->name : 'Vendedor' }},</h1>
<p>Seu produto <strong>{{ $product->name }}</strong> foi cadastrado com sucesso na nossa plataforma.</p>

<h3>Detalhes do Produto:</h3>
<ul>
    <li><strong>Imagem:</strong><img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" /></li>
    <li><strong>Nome:</strong> {{ $product->name }}</li>
    <li><strong>Descrição:</strong> {{ $product->description ?? 'Sem descrição' }}</li>
    <li><strong>Preço:</strong> R${{ number_format($product->price ?? 0, 2, ',', '.') }}</li>
    <li><strong>Link para visualizar o produto:</strong> <a href="{{ url('api/products/' . $product->id) }}">Ver Produto</a></li>
</ul>

<p>Atenciosamente,<br>Equipe {{ config('app.name') }}</p>
</body>
</html>
