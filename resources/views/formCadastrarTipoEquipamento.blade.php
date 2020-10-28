@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Cadastro Tipo Equipamento') }}</div>

                    <div class="card-body">
                        <form action="{{route('tipoEquipamento.criar')}}" method="POST">
                            @csrf

                            <div class="form-group ">
                                <div>
                                    <label for="nome">Nome</label>
                                    <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}"  required autocomplete="nome" autofocus>

                                    @error('nome')
                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group ">
                                <div>
                                    <label for="descricao">Descricao</label>
                                    <input id="descricao" type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ old('descricao') }}" autocomplete="descricao" required autofocus>

                                    @error('descricao')
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group ">
                                <div>
                                    <label for="quantidade">Quantidade</label>
                                    <input id="quantidade" type="text" class="form-control @error('quantidade') is-invalid @enderror" name="quantidade" value="{{ old('quantidade') }}"  required autocomplete="quantidade" autofocus>

                                    @error('quantidade')
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-primary" >{{ __('Cadastrar') }}</button>
                                </div>
                            </div>


                        </form>
                    </div>
            </div>
        </div>
    </div>

@endsection
