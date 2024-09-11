@extends('layouts.main')

@section('title', 'Listagem Produto')

@section('content')
<link rel='stylesheet' href='../css/list.css'>
<h1>Listagem de Produtos</h1>
<table class="list-table">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Foto</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($produtos as $produto)
            <tr>
                <td>{{ $produto->nome }}</td>
                <td>{{ $produto->preco }}</td>
                <td><img src="/img/produtos/{{$produto->foto}}" style="width: 100px; height: 100px;"></td>

                <td>
                    <a href="{{ route('produto.edit', $produto->id) }}" class="btn-edit">Editar</a>                        
                    <form action="{{ route('produto.destroy', ['id' => $produto->id]) }}" method="post" class="form-delete">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn-delete" onclick="return confirm('Tem certeza?')">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<a class="btn-create" href="/produto/create">Cadastrar</a>

@endsection

