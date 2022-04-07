<?php //Herda o código de app.blade.php ?>
@extends('layouts.app')

@section('navegacao')
    <div class="col-3 bg-secondary text-white-50 vh-100">
        <p class="text-center mt-3 mb-5 fw-bold fs-4"> 
            <i class="fas fa-money-bill-wave"></i> 
            APP FINANÇAS
        </p>

        <p class="text-center mt-3 mb-5"> 
            <i class="fas fa-user fa-4x"></i><br>
            Olá, {{$user->name}}
        </p>

        <nav class="nav flex-column text-center">
            <a class="nav-link text-white" href="{{route('dashboard')}}">Extrato</a>
            <a class="nav-link text-white" href="{{route('novo_movimento')}}">Novo Movimento</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="nav-link text-light" href="{{ route('logout') }}" onclick="event.preventDefault();
                            this.closest('form').submit(); " role="button">
                    <i class="fas fa-sign-out-alt"></i>

                    {{ __('Sair') }}
                </a>
            </form>
        </nav>
    </div>

@endsection


@section('extrato')
    <div class="col-9 text-secondary">
        <p class="mb-5 p-2 fw-bold fs-4 border-bottom border-secondary"> 
            EXTRATO - {{  'R$ '.number_format($totaldespesas-$totalreceitas, 2, ',', '.') }}
        </p>

        <div class="row">
            <div class="col-md-6">
                <p class="fs-2">Receitas</p>
                {{-- lista de receitas --}}

                @foreach($receitas as $receita)
                <div class="card mb-3">
                    <div class="card-header">
                    {{Carbon\Carbon::parse($receita->data)->format('d/m/Y') }}
                    </div>
                    <div class="card-body">
                        {{$receita->descricao}}
                        <p>Valor {{  'R$ '.number_format($receita->valor, 2, ',', '.') }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('editar', [$receita->id])}}" ><i class="fas fa-edit"></i></a>    
                        <form action="{{route('deletar',[$receita->id])}}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link"
                            onclick="if (!confirm('Excluir este movimento?')) { return false }">
                            <i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                </div>
                @endforeach

                {{-- total de receitas --}}
                <p class="fw-bold">Total: {{  'R$ '.number_format($totalreceitas, 2, ',', '.') }}</p>
            </div>
            
            <div class="col-md-6">
                <p class="fs-2">Despesas</p>
                {{-- lista de despesas --}}

                @foreach($despesas as $despesa)
                <div class="card mb-3">
                    <div class="card-header">
                    {{Carbon\Carbon::parse($despesa->data)->format('d/m/Y') }}
                    </div>
                    <div class="card-body">
                    {{$despesa->descricao}}
                        <p>Valor {{  'R$ '.number_format($despesa->valor, 2, ',', '.') }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('editar', [$despesa->id])}}" ><i class="fas fa-edit"></i></a>    
                        <form action="{{route('deletar',[$despesa->id])}}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link"
                            onclick="if (!confirm('Excluir este movimento?')) { return false }">
                            <i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                </div>
                @endforeach

                {{-- total de despesas --}}
                <p class="fw-bold">Total: {{  'R$ '.number_format($totaldespesas, 2, ',', '.') }}</p>
            </div>
        </div>
    </div>
@endsection