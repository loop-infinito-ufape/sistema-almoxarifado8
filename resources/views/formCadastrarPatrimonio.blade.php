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

<form action="{{route('patrimonio.criar')}}" method="POST">
    @csrf
    <div>
        <h1>Cadastro Patrimonio</h1>
    </div>
    <div class="form-group ">
        <div>
            <label for="numero">Número</label>
            <input id="numero" type="number" class="form-control @error('numero') is-invalid @enderror"  name="numero" value="{{ old('numero') }}"  required autocomplete="numero" autofocus>

            @error('numero')
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
            @enderror
        </div>
    </div>

    <div class="form-group ">
        <div>
            <label for="tipo_equipamento_id">Tipo Equipamento</label>
            <select name="tipo_equipamento_id" id="tipo_equipamento_id" class="form-control @error('tipo_equipamento_id') is-invalid @enderror"  name="tipo_equipamento_id" required autocomplete="tipo_equipamento_id" autofocus >
                @foreach($tiposEquipamentos as $tipoEquipamento)
                    <option id="optionComOValor" value="{{$tipoEquipamento->id}}">{{$tipoEquipamento->nome}}</option>
                @endforeach
            </select>
            @error('tipo_equipamento_id')
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
