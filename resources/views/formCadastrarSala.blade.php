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

<form action="{{route('sala.criar')}}" method="POST">
@csrf
    <div>
        <h1>Cadastro Sala</h1>
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
            <label for="ramal">Ramal</label>
            <input id="ramal" type="ramal" class="form-control @error('ramal') is-invalid @enderror" name="ramal" value="{{ old('ramal') }}" autocomplete="ramal" autofocus>

            @error('ramal')
            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
            @enderror
        </div>
    </div>

    <div class="form-group ">
        <div>
            <label for="predio">Prédio</label>
            <input id="predio" type="text" class="form-control @error('predio') is-invalid @enderror" name="predio" value="{{ old('predio') }}"  required autocomplete="predio" autofocus>

            @error('predio')
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
