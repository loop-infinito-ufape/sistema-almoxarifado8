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

<form action="{{route('pedido.criarTemporiamente')}}" method="POST">
    @csrf
    <div>
        <h1>Cadastro Pedido</h1>
        <h3 style="color: darkgreen">{{$mensagem}}</h3>
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
            <button type="submit" >{{ __('Anexar') }}</button>
        </div>
    </div>


</form>

<div>
    <h3>Lista de Equipamentos</h3>
    @foreach(Session::get('pedidos') as $k => $item)

        <a href="editar?quantidade_pedida={{$item['quantidade_pedida']}}&descricao={{$item['descricao']}}&tipo_equipamento_id={{$item['tipo_equipamento_id']}}"><span style="font-weight: bold;">Nome:</span> {{ $item['nome_equipamento']}} <span style="font-weight: bold;">Descrição:</span> {{$item['descricao']}} <span style="font-weight: bold;">QTD:</span> {{$item['quantidade_pedida']}}</a>
        <p></p>

    @endforeach

    <div style="background: #000">
        <a href="cadastrar"><span style="font-weight: bold;">Concluir</span></a>
    </div>
<div>

</body>
</html>
