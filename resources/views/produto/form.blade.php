@extends('layouts.main')

@php
    $produto = $produto ?? null; //para abrir com form de cadastrar
@endphp

@section('title', $produto ? 'Editar Produto':'Cadastrar Produto')

@section('content')
<link rel='stylesheet' href='../css/form.css'>
<form action="{{ $produto ? route('produto.update', ['id' => $produto->id]) : route('produto.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @isset($produto)
        @method('put')
    @endisset
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="{{old('nome', $produto->nome ?? '')}}" required>

    <label for="preco">Preço:</label>
    <input type="text" id="preco" name="preco" value="{{old('preco', $produto->preco ?? '')}}" required>

    <label for="foto">Foto:</label>
    <input type="file" id="foto" name="foto" accept="image/jpeg, image/png" >

    <button type="submit">{{$produto? 'Atualizar' : 'Salvar'}}</button> 
    <a class="btn-back" href="/produto">Voltar</a>
</form>
@endsection