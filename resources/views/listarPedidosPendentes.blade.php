@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Listar equipamento') }}</div>

                    <div class="card-body">
                        <div class="form-group row">
                            <table>
                                <tr>
                                    <th>ID</th>
                                    <th>Equipamento</th>
                                    <th>Status</th>
                                    <th>Quantidade</th>
                                </tr>
                                @foreach($pedidos as $pedido)
                                    <tr>
                                        <td>{{$pedido['id']}}</td>
                                        <td>{{$pedido['nome_equipamento']}}</td>
                                        <td>{{$pedido['status']}}</td>
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
