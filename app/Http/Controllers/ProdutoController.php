<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Produto;
use App\Models\User;

use Illuminate\Support\Facades\Log;

class ProdutoController extends Controller
{
    public function index()
    {
        return view('produto.index', ['produtos' => Produto::all()]);
    }

    public function create()
    {
        return view('produto.form');
    }


    public function store(Request $request)
    {
        $produto = new Produto;

        try {


            Log::info($request);
            $produto->nome = $request->nome;
            $produto->preco = $request->preco;

            if($request->hasFile("foto") && $request->file('foto')->isValid()) {
                $requestFoto = $request->foto;
                $extension = $requestFoto->extension();
                $fotoName = md5($requestFoto->getClientOriginalName() . strtotime("now")) . "." . $extension;
                $requestFoto->move(public_path('img/produtos'), $fotoName);
                $produto->foto = $fotoName;
            }
            
            $produto->save();
            return redirect('/produto')->with('success', 'Produto salvo com sucesso!');
        } catch (\Exception $e) {
            $msgErro='';
            if ($e->getCode() == 23000) {
                $msgErro='Ver o erro da foto';
            } else { 
                $msgErro=$e->getMessage();
            }
            Log::info($e->getMessage());
            return redirect()->back()->withErrors($msgErro)->withInput();
        }        
    }

    public function destroy($id) {
        Produto::findOrFail($id)->delete();
        return redirect('/produto')->with('success', 'Produto excluído com sucesso!');
    }

    public function edit($id) {
        $produto = Produto::findOrFail($id);
        return view('produto.form',['produto'=> $produto ]);
    }

    public function update(Request $request, $id)
{
    try {
        $produto = Produto::findOrFail($id);
        
        $produto->nome = $request->nome;
        $produto->preco = $request->preco;
        //$produto->foto = $request->foto;

        $produto->update();

        return redirect('/produto')->with('success', 'Produto atualizado com sucesso!');
    } catch (\Exception $e) {
        $msgErro='';
        if ($e->getCode() == 23000) {
            $msgErro='idemCreate';
        } else { 
            $msgErro='Erro ao inserir';
        }            
        return redirect()->back()->withErrors($msgErro)->withInput();
    }
}

















}
