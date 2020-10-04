<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<form action="{{route('tipoEquipamento.criar')}}" method="POST">
    @csrf
    <div>
        <h1>Cadastro Tipo Equipamento</h1>
    </div>
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
            <button type="submit" >{{ __('Cadastrar') }}</button>
        </div>
    </div>


</form>

</body>
</html>
