@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Cadastro Pedido') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{route('pedido.criarTemporiamente')}}" method="POST">
                                    @csrf
                                    <div>
                                        @if(str_contains($mensagem, 'Error:'))
                                            <h3 style="color: red">{{$mensagem}}</h3>
                                        @else
                                            <h3 style="color: darkgreen">{{$mensagem}}</h3>
                                        @endif
                                    </div>

                                    <div class="form-group ">
                                        <div>
                                            <label for="tipo_equipamento_id">Tipo Equipamento</label>
                                            <select name="tipo_equipamento_id" id="tipo_equipamento_id" class="form-control @error('tipo_equipamento_id') is-invalid @enderror"  name="tipo_equipamento_id" required autocomplete="tipo_equipamento_id" autofocus >
                                                @foreach($tiposEquipamentos as $tipoEquipamento)
                                                    <option {{$tipoEquipamento->id == $tipo_equipamento_id ? 'selected' : ''}} id="optionComOValor" value="{{$tipoEquipamento->id}}">{{$tipoEquipamento->nome}}</option>
                                                @endforeach
                                            </select>
                                            @error('tipo_equipamento_id')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <div>
                                            <label for="quantidade_pedida">Quantidade</label>
                                            <input id="quantidade_pedida" type="number" class="form-control @error('quantidade_pedida') is-invalid @enderror" name="quantidade_pedida" value="{{ $quantidade_pedida }}" autocomplete="quantidade_pedida" autofocus>
                                        </div>
                                        @error('quantidade_pedida')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="form-group ">
                                        <div>
                                            <label for="descricao">Descrição</label>
                                            <input id="descricao" type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ $descricao }}" autocomplete="descricao" autofocus>

                                            @error('descricao')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div>
                                            <button type="submit" class="btn btn-primary" >{{ __('Anexar') }}</button>
                                        </div>
                                    </div>


                                </form>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="numeros">{{ __('Lista de Equipamentos') }}</label>

                                            <table class="table">
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Descrição</th>
                                                    <th>QTD</th>
                                                </tr>
                                                @foreach(Session::get('pedidos') as $k => $item)
                                                    <tr>
                                                        <td>{{$item['nome_equipamento']}}</td>
                                                        <td>{{$item['descricao']}}</td>
                                                        <td>{{$item['quantidade_pedida']}}</td>
                                                        <td><a href="{{route('pedido.removerparcial',['id'=>$item['tipo_equipamento_id']])}}">remover</a></td>
                                                    </tr>
                                                @endforeach

                                            </table>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <a href="cadastrar" type="submit" class="btn btn-primary">
                                            {{__('Concluir') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

@endsection
