<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

use Illuminate\Support\Facades\Log;

class ClienteController extends Controller
{

    public function index()
    {
        $cliente = Cliente::all();
        return view('cliente.index', ['clientes' => $cliente]);
    }

    public function create()
    {
        return view('cliente.form');
    }

    public function store(Request $request)
    {
        $cliente = new Cliente;

        Log::info($request);
        try {
            $cliente->nome = $request->nome;
            $cliente->email = $request->email;
            $cliente->dataNasc = $request->dataNasc;
            $cliente->telefone = $request->telefone;
            $cliente->endereco = $request->endereco;
            $cliente->complemento = $request->complemento;        
            $cliente->bairro = $request->bairro;        
            $cliente->cep = $request->cep;
            
            $cliente->save();
            return redirect('/cliente')->with('success', 'Cliente salvo com sucesso!');
        } catch (\Exception $e) {
            $msgErro='';
            if ($e->getCode() == 23000) {
                $msgErro='E-mail já existe na base de dados';
            } else { 
                $msgErro='Erro ao inserir';
            }
            Log::error($e->getMessage());
            return redirect()->back()->withErrors($msgErro)->withInput();
        }

        
    }

    public function destroy($id) {
        Cliente::findOrFail($id)->delete();
        return redirect('/cliente')->with('success', 'Cliente excluído com sucesso!');
    }

    public function edit($id) {
        $cliente = Cliente::findOrFail($id);
        return view('cliente.form',['cliente'=> $cliente ]);
    }

    public function update(Request $request, $id)
{
    try {
        $cliente = Cliente::findOrFail($id);
        
        $cliente->nome = $request->nome;
        $cliente->email = $request->email;
        $cliente->dataNasc = $request->dataNasc;
        $cliente->telefone = $request->telefone;
        $cliente->endereco = $request->endereco;
        $cliente->complemento = $request->complemento;        
        $cliente->bairro = $request->bairro;        
        $cliente->cep = $request->cep;

        $cliente->update();

        return redirect('/cliente')->with('success', 'Cliente atualizado com sucesso!');
    } catch (\Exception $e) {
        $msgErro='';
        if ($e->getCode() == 23000) {
            $msgErro='E-mail já existe na base de dados';
        } else { 
            $msgErro='Erro ao inserir';
        }            
        return redirect()->back()->withErrors($msgErro)->withInput();
    }
}

}
