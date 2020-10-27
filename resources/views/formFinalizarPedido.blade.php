@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Finalizar Pedido') }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{route('pedido.concluirfinalizacao')}}" method="POST">
                                    @csrf
                                    <div>
                                        @if(str_contains($mensagem, 'Error:'))
                                            <h3 style="color: red">{{$mensagem}}</h3>
                                        @else
                                            <h3 style="color: darkgreen">{{$mensagem}}</h3>
                                        @endif
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="nome_equipamento">Nome Equipamento</label>
                                            <input id="nome_equipamento" disabled="true" type="text" class="form-control @error('nome_equipamento') is-invalid @enderror" name="nome_equipamento" value="{{$nome_equipamento}}" autocomplete="nome_equipamento" autofocus>
                                        </div>
                                        @error('nome_equipamento')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="lista">Patrimonio</label>
                                            <table>
                                                <tr>
                                                    <th>Numeros</th>
                                                </tr>
                                                @foreach(Session::get('lista') as $i => $id)
                                                    <tr>
                                                        <td>
                                                            @foreach($patrimonios2 as $patrimonio)
                                                                @if($patrimonio->id == $id)
                                                                    {{$patrimonio->numero}}
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td><a href="{{route('remover.patrimonio',['id' => $i,'id_pedido'=>$id_pedido])}}">Remover</a></td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="quantidade_solicitada">Quantidade Solicitada</label>
                                            <input id="quantidade_solicitada" disabled="number" type="text" class="form-control @error('quantidade_solicitada') is-invalid @enderror" name="quantidade_solicitada" value="{{$quantidade_solicitada}}" autocomplete="quantidade_solicitada" autofocus>
                                        </div>
                                        @error('quantidade_solicitada')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            @if(sizeof($patrimonios)>0)
                                                <label for="quantidade_enviada">Quantidade Enviada</label>
                                                <input id="quantidade_enviada" required type="number" max="{{$quantidade_solicitada}}" min="1" class="form-control @error('quantidade_enviada') is-invalid @enderror" name="quantidade_enviada" value="{{sizeof(Session::get('lista'))}}" autocomplete="quantidade_enviada" autofocus>
                                                @error('quantidade_enviada')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            @else
                                                <label for="quantidade_enviada">Quantidade Enviada</label>
                                                <input id="quantidade_enviada" required type="number" max="{{$quantidade_solicitada}}" min="1" class="form-control @error('quantidade_enviada') is-invalid @enderror" name="quantidade_enviada" value="" autocomplete="quantidade_enviada" autofocus>
                                                @error('quantidade_enviada')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            @endif
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="descricao">Descrição do Pedido</label>
                                            <input id="descricao" type="text" disabled="true" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{$descricao}}" autocomplete="descricao" autofocus>
                                        </div>
                                        @error('descricao')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="resposta_pedido">Resposta ao Pedido</label>
                                            <input id="resposta_pedido" required type="text" class="form-control @error('resposta_pedido') is-invalid @enderror" name="resposta_pedido" value="" autocomplete="resposta_pedido" autofocus>
                                        </div>
                                        @error('resposta_pedido')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <input id="id_pedido" hidden type="text"  name="id_pedido" value="{{$id_pedido}}">

                                    <input id="id_equipamento" hidden type="text"  name="id_equipamento" value="{{$id_equipamento}}">

                                    <div class="form-group">
                                        <div>
                                            <button type="submit" class="btn btn-primary">{{ __('Finalizar') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form action="{{route('patrimonio.anexar')}}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="patrimonios">Num Patrimonio</label>
                                            <select name="patrimonios" id="patrimonios" class="form-control @error('patrimonios') is-invalid @enderror"  name="patrimonios" autocomplete="patrimonios" autofocus >
                                                @foreach($patrimonios as $patrimonio)
                                                    <option id="optionComOValor" value="{{$patrimonio->id}}">{{$patrimonio->numero}}</option>
                                                @endforeach
                                            </select>
                                            @error('patrimonios')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <input id="id_pedido" hidden type="text"  name="id_pedido" value="{{$id_pedido}}">
                                    <input id="id_equipamento" hidden type="text"  name="id_equipamento" value="{{$id_equipamento}}">
                                    <input id="nome_equipamento" hidden type="text" name="nome_equipamento" value="{{$nome_equipamento}}">
                                    <input id="quantidade_solicitada" hidden type="text" name="quantidade_solicitada" value="{{$quantidade_solicitada}}" autocomplete="quantidade_solicitada" autofocus>
                                    <input id="descricao" hidden type="text" name="descricao" value="{{$descricao}}">

                                    <div class="form-group">
                                        <div>
                                            <button type="submit" class="btn btn-primary">{{ __('Anexar') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
