@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Pedidos Pendentes') }}</div>

                    <div class="card-body">
                        <div class="form-group row">
                            <table style="width: 100%; text-align: center;" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Equipamento</th>
                                        <th>Servidor</th>
                                        <th>Data</th>
                                        <th>Status</th>
                                        <th>Quantidade</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @foreach($pedidos as $pedido)
                                    <tr>
                                        <td>{{$pedido['nome_equipamento']}}</td>
                                        <td>{{$pedido['nome_servidor']}}</td>
                                        <td>{{$pedido['data_inicial']}}</td>
                                        <td>{{$pedido['status']}}</td>
                                        <td>{{$pedido['quantidade']}}</td>
                                        <td><a href="finalizar?quantidade={{$pedido['quantidade']}}&descricao={{$pedido['descricao']}}&id_equipamento={{$pedido['id_equipamento']}}&nome_equipamento={{$pedido['nome_equipamento']}}&id_pedido={{$pedido['id_pedido']}}">Finalizar<a></td>
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
