@extends('layouts.main')

@php
    $pedido = $pedido ?? null; //para abrir com form de cadastrar
@endphp

@section('title', $pedido ? 'Editar Pedido':'Cadastrar Pedido')

@section('content')
<link rel='stylesheet' href='../css/form.css'>
<form action="{{ $pedido ? route('pedido.update', ['id' => $pedido->id]) : route('pedido.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @isset($pedido)
        @method('put')
    @endisset
    <label for="nome">Cliente:</label>
    <select name="cliente" id="cliente" required>
        <option value=""></option>
        @foreach($clientes as $cliente)
            <option value="{{ $cliente->id }}" {{$pedido && $pedido->cliente==$cliente?'selected':''}}>{{ $cliente->nome }}</option>
        @endforeach
    </select>

    Itens:
    <table class="itens">
        <thead>
            <tr>
                <th></th>
                <th></th>
                <th>Produto</th>                
                <th>Preço</th> 
            </tr>
        </thead>
        <tbody>
            @foreach($produtos as $produto)
                <tr>
                    @if (null !== ($pedido && $pedido->item_pedidos->where('produto_id', $produto->id)->first()))
                    <td><input type="number" name="quantidadeProduto[{{ $produto->id }}]" 
                        value="{{ $pedido->item_pedidos->where('produto_id', $produto->id)->first()->quantidade ?? 0 }}" min="0" style="width: 50px;" onchange="calculaTotal()"></td>
                    @else
                    <td><input type="number" name="quantidadeProduto[{{ $produto->id }}]" 
                        value="0" min="0" style="width: 50px;" onchange="calculaTotal()"></td>
                    @endif
                    <td><img src="/img/produtos/{{ $produto->foto }}" alt="{{ $produto->nome }}" width="50"></td>
                    <td>{{ $produto->nome }}</td>                    
                    <td><input type="hidden" name="precoProduto[{{ $produto->id }}]" value="{{ $produto->preco }}">{{ $produto->preco }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

   
    <label for="conta">Total:</label>
    <input type="text" id="conta" name="conta" value="{{$pedido? $pedido->conta:0}}" readonly> 
    
    <button type="submit">{{$pedido? 'Atualizar' : 'Salvar'}}</button> 
    <a class="btn-back" href="/pedido">Voltar</a>
</form>

@endsection
@verbatim
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function calculaTotal() {
        var conta = 0;
        $('.itens tbody tr').each(function( ) {
            var quantidade = $(this).find('td:eq(0) input').val();
            var preco = parseFloat($(this).find('td:eq(3)').text().replace(',', '.'));
            var subtotal = quantidade * preco;
            conta += subtotal;
        });            
        
        $('#conta').val(conta.toFixed(2));    
    }
</script>
@endverbatim