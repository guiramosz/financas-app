<?php

namespace App\Http\Controllers;

use App\Models\Fin_movimento;
use Illuminate\Http\Request;

class MovimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Dados do usuário
        $user = auth()->user();
        //Movimentos de despesa do usuário logado
        $despesas = Fin_movimento::where('user_id', $user->id)
        ->where('tipo', 'Despesa')->get();
        //Movimentos de receitas do usuário logado
        $receitas = Fin_movimento::where('user_id', $user->id)
        ->where('tipo', 'Receita')->get();

        $totaldespesas = $despesas->sum('valor');
        $totalreceitas = $receitas->sum('valor'); 

        $parametros = [
            'despesas' => $despesas,
            'receitas' => $receitas,
            'user' => $user,
            'totaldespesas' => $totaldespesas,
            'totalreceitas' => $totalreceitas
        ];

        return view('dashboard', $parametros );
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $movimento = new Fin_movimento;
        
        $movimento->valor = $request->valor;
        $movimento->descricao = $request->descricao;
        $movimento->tipo = $request->tipo;
        $movimento->data = date('Y-m-d');
        $user = auth()->user();
        $movimento->user_id= $user->id;
        
        $movimento->save();
        return redirect('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fin_movimento  $fin_movimento
     * @return \Illuminate\Http\Response
     */
    public function show(Fin_movimento $fin_movimento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fin_movimento  $fin_movimento
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $movimento = Fin_movimento::findOrFail($id);
        $parametros = [
            'movimento' => $movimento,
            'user' => $user = auth()->user()
        ];
        return view ('editar', $parametros);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fin_movimento  $fin_movimento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Fin_movimento::findOrFail($request->id)->update($request->all());
        return redirect('dashboard');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fin_movimento  $fin_movimento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Fin_movimento::findOrFail($id)->delete();
        return redirect('/dashboard');
    }
}
