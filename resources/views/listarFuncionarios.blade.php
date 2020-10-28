@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Listar Funcionarios') }}</div>

                    <div class="card-body">
                        <div class="form-group row">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                @foreach($servidores as $servidor)
                                    <tr>
                                        <td>{{$servidor->id}}</td>
                                        <td>{{$servidor->name}}</td>
                                        <td>{{$servidor->email}}</td>
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
