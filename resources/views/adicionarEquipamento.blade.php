@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Adicionar equipamento') }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form id="form1" method="POST" action="{{ route('adicionar') }}">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="name">{{ __('Equipamento') }}</label>

                                            <select id="tipo_id"  class="form-control" name="tipo_id" autocomplete="tipo_id" autofocus>
                                                <option value="">Indefinido</option>
                                                @foreach($tipos as $tipo)
                                                    <option value="{{$tipo->id}}">{{$tipo->nome}} - {{$tipo->descricao}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="quantidade" >{{ __('Quantidade') }}</label>

                                            <input id="quantidade" type="quantidade" class="form-control @error('quantidade') is-invalid @enderror" name="quantidade" value="{{ sizeof(Session::get('lista')) }}" required autocomplete="quantidade">

                                            @error('quantidade')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <div class="col-md-12">
                                            <label for="numeros">{{ __('NumPatrimonio') }}</label>

                                            <table>
                                                <tr>
                                                    <th>Numero</th>
                                                </tr>
                                                @foreach(Session::get('lista') as $i => $patrimonio)
                                                    <tr>
                                                        <td>{{$patrimonio}}</td>
                                                        <td><a href="{{route('remover',['id' => $i])}}">Remover</a></td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Adicionar') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form method="POST" action="{{ route('anexar') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="numero">{{ __('Numero') }}</label>

                                            <input id="numero" type="numero" class="form-control @error('numero') is-invalid @enderror" name="numero" value="{{ old('numero') }}" required autocomplete="quantidade">

                                            @error('numero')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Anexar') }}
                                        </button>
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
