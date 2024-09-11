@extends('layouts.main')

@section('title', 'Listagem Cliente')

@section('content')
<link rel='stylesheet' href='../css/list.css'>
<h1>Listagem de Clientes</h1>

    <table class="list-table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Data Cadastro</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td>{{ \Carbon\Carbon::parse($cliente->created_at)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('cliente.edit', $cliente->id) }}" class="btn-edit">Editar</a>                        
                        <form action="{{ route('cliente.destroy', ['id' => $cliente->id]) }}" method="post" class="form-delete">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn-delete" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a class="btn-create" href="/cliente/create">Cadastrar</a>
@endsection

