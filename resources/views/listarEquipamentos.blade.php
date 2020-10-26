@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Listar equipamento') }}
                        <a href="{{route('pedido.criar')}}">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Consumo -') }}
                            </button>
                        </a>
                        <a href="{{route('prepararAdicionar')}}">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Adicionar + ') }}
                            </button>
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <table>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Quantidade</th>
                                </tr>
                                @foreach($tipos as $tipo)
                                    <tr>
                                        <td>{{$tipo->id}}</td>
                                        <td>{{$tipo->nome}}</td>
                                        <td>{{$tipo->descricao}}</td>
                                        <td>{{$tipo->quantidade}}</td>
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
