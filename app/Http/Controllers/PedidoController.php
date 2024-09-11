<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\ItemPedido;
use App\Models\Pedido;
use App\Models\Log;


class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('cliente')->get();
        return view('pedido.index', ['pedidos' => $pedidos]);
    }

    public function create()
    {
        $clientes = Cliente::all();
        $produtos = Produto::all();
        return view('pedido.form',['clientes' => $clientes, 'produtos' => $produtos]);
    }

    public function store(Request $request)
    {
        try {
            $pedido = new Pedido;
            $items = [];
            $valorTotal = 0;
            $idCliente = $request->cliente;
            $quantidades = $request->quantidadeProduto;
            $precos = $request->precoProduto;           
            foreach  ($quantidades as $chave => $qtd) {
                if ($qtd>0) {        
                    $item = new ItemPedido;  
                    $item->quantidade = $qtd;
                    $item->produto_id = $chave;   
                    $valorParcial = $qtd * $precos[$chave];
                    $valorTotal += $valorParcial;
                    array_push($items, $item);                 
                }
            }
            if ($valorTotal==0) {
                return redirect()->back()->withErrors(['conta' => 'A conta do pedido deve ser maior que zero.']);
            }
            
            $pedido->cliente_id = $idCliente;
            $pedido->conta = $valorTotal;
            $pedido->save();

            $pedido_id = $pedido->id;

            foreach  ($items as $item) {
                $item->pedido_id = $pedido_id;
                $item->save();
            }
            
            return redirect('/pedido')->with('success', 'Pedido salvo com sucesso!');
        } catch (\Exception $e) {
            //dd($request->all());
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id) {
        Pedido::findOrFail($id)->delete();
        return redirect('/pedido')->with('success', 'Pedido excluído com sucesso!');
    }

    public function edit($id) {
        $pedido = Pedido::findOrFail($id);

        $clientes = Cliente::all();
        $produtos = Produto::all();

        //return view('pedido.form',['pedido'=> $pedido, 'clientes'=>$pedido->cliente, 'produtos' => Produto::all() ]);
        return view('pedido.form',['pedido'=> $pedido,'clientes' => $clientes, 'produtos' => $produtos]);
    }

    public function update(Request $request, $id)
    {
        try {
            $pedido = Pedido::findOrFail($id);
            $idCliente = $request->cliente;

            $itemsAtuais = $pedido->item_pedidos;
            
            $valorTotal = 0;
            
            $quantidades = $request->quantidadeProduto;
            $precos = $request->precoProduto;    
            
            //throw new \Exception($itemsAtuais);
            foreach  ($quantidades as $chave => $qtd) {                
                $itemAtual = collect($itemsAtuais)->where('produto_id', $chave)->first();
                if ($qtd>0) {                      
                    if ($itemAtual==null) {
                        $item = new ItemPedido;
                        $item->quantidade = $qtd;
                        $item->produto_id = $chave;
                        $item->pedido_id = $id;
                        $item->save();
                    } else if ($itemAtual->quantidade!=$qtd) {                        
                        $item = $itemAtual;
                        $item->quantidade = $qtd;
                        $item->update();                         
                    }
                    $valorParcial = $qtd * $precos[$chave];
                    $valorTotal += $valorParcial;                  
                } else {
                    if ($itemAtual!=null) {
                        $itemAtual->delete();
                    }
                }
            }
            if ($valorTotal==0) {
                return redirect()->back()->withErrors(['O pedido deve conter ao menos um item']);
            }
            

            $pedido->cliente_id = $idCliente;
            $pedido->conta = $valorTotal;

            $pedido->update();

            return redirect('/pedido')->with('success', 'Cliente atualizado com sucesso!');
        } catch (\Exception $e) {
            //dd($request->all());
            /*if ($e->getCode() == 23000) {
                $msgErro='E-mail já existe na base de dados';
            } else { 
                $msgErro='Erro ao inserir';
            } */           
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
