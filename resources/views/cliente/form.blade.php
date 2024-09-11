@extends('layouts.main')
@php
    $cliente = $cliente ?? null; //para abrir com form de cadastrar
@endphp

@section('title', $cliente ? 'Editar Cliente':'Cadastrar Cliente')

@section('content')
<link rel='stylesheet' href='../css/form.css'>

<form action="{{ $cliente ? route('cliente.update', ['id' => $cliente->id]) : route('cliente.store') }}" method="post">

    @csrf
    @isset($cliente)
        @method('put')
    @endisset
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="{{old('nome', $cliente->nome ?? '')}}" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="{{old('email', $cliente->email?? '')}}" required>

    <label for="telefone">Telefone:</label>
    <input type="tel" id="telefone" name="telefone" value="{{old('telefone', $cliente->telefone?? '')}}" pattern="[0-9]*" maxlength="11" required>

    <label for="dataNasc">Data de Nascimento:</label>
    <input type="date" id="dataNasc" name="dataNasc" value="{{ old('dataNasc', $cliente ? \Carbon\Carbon::parse($cliente->dataNasc)->format('Y-m-d') : '') }}" required>

    <label for="endereco">Endereço:</label>
    <input type="text" id="endereco" name="endereco" value="{{old('endereco', $cliente->endereco?? '')}}">

    <label for="complemento">Complemento:</label>
    <input type="text" id="complemento" name="complemento" value="{{old('complemento', $cliente->complemento?? '')}}">

    <label for="bairro">Bairro:</label>
    <input type="text" id="bairro" name="bairro" value="{{old('bairro', $cliente->bairro?? '')}}" required>

    <label for="cep">CEP:</label>
    <input type="text" id="cep" name="cep" value="{{old('cep', $cliente->cep?? '')}}" pattern="[0-9]*" maxlength="8" >

    <button type="submit">{{$cliente? 'Atualizar' : 'Salvar'}}</button> 
    <a class="btn-back" href="/cliente">Voltar</a>
</form>
@endsection