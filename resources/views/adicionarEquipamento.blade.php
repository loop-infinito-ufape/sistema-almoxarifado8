@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Adicionar equipamento') }}</div>

                    <div class="card-body">
                        <form id="form1" method="POST" action="{{ route('adicionar') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Equipamento') }}</label>

                                <div class="col-md-6">

                                    <select id="tipo_id"  class="form-control" name="tipo_id" autocomplete="tipo_id" autofocus>
                                        <option value="">Indefinido</option>
                                        @foreach($tipos as $tipo)
                                            <option value="{{$tipo->id}}">{{$tipo->nome}} - {{$tipo->descricao}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="quantidade" class="col-md-4 col-form-label text-md-right">{{ __('Quantidade') }}</label>
                                <div class="col-md-6">
                                    <input id="quantidade" type="quantidade" class="form-control @error('quantidade') is-invalid @enderror" name="quantidade" value="{{ sizeof(Session::get('lista')) }}" required autocomplete="quantidade">

                                    @error('quantidade')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('NumPatrimonio') }}</label>

                                <div class="col-md-6">
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

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Adicionar') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <form method="POST" action="{{ route('anexar') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="numero" class="col-md-4 col-form-label text-md-right">{{ __('Numero') }}</label>

                                <div class="col-md-6">
                                    <input id="numero" type="numero" class="form-control @error('numero') is-invalid @enderror" name="numero" value="{{ old('numero') }}" required autocomplete="quantidade">

                                    @error('numero')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Anexar') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
