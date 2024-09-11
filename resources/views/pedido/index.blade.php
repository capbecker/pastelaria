@extends('layouts.main')

@section('title', 'Listagem Pedido')

@section('content')
<link rel='stylesheet' href='../css/list.css'>
<h1>Listagem de Pedido</h1>
<table class="list-table">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Conta</th>
            <th>Data Cadastro</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->cliente->nome }}</td>
                <td>R${{ $pedido->conta}}</td>
                <td>{{ \Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('pedido.edit', $pedido->id) }}" class="btn-edit">Editar</a>                        
                    <form action="{{ route('pedido.destroy', ['id' => $pedido->id]) }}" method="post" class="form-delete">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn-delete" onclick="return confirm('Tem certeza?')">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<a class="btn-create" href="/pedido/create">Cadastrar</a>

@endsection

