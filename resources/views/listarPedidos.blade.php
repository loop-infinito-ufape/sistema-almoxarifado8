@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Listar Pedidos') }}</div>

                    <div class="card-body">
                        <div class="form-group row">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Descrição</th>
                                        <th>Quantidade</th>
                                    </tr>
                                </thead>
                                @foreach($pedidos as $pedido)
                                    <tr>
                                        <td>{{$pedido->id}}</td>
                                        <td>{{$pedido->descricao}}</td>
                                        <td>{{$pedido->quantidade_pedida}}</td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
