@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Histórico') }}</div>

                    <div class="card-body">
                        <div class="form-group row">
                            <table style="width: 100%; text-align: center;" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Equipamento</th>
                                        <th>Servidor</th>
                                        <th>Data Solicitação</th>
                                        <th>Data Liberação</th>
                                        <th>Quantidade</th>
                                    </tr>
                                </thead>
                                @foreach($pedidos as $pedido)
                                    <tr>
                                        <td>{{$pedido['nome_equipamento']}}</td>
                                        <td>{{$pedido['nome_servidor']}}</td>
                                        <td>{{$pedido['data_inicial']}}</td>
                                        <td>{{$pedido['data_final']}}</td>
                                        <td>{{$pedido['quantidade']}}</td>
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
