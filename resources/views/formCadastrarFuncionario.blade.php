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

    <!-- formulario de inscricao de funcionario-->
    <form action="{{route('funcionario.criar')}}" method="POST">
        @csrf

        <!-- div com label + input area formam um grup form -->
        <div class="form-group ">
            <!-- div com label -->
            <div>
                <label for="nome">Nome</label>
                <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}"  required autocomplete="nome" autofocus>

                <!-- captura o erro e exibe pra o usuario -->
                @error('nome')
                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                @enderror
            </div>
        </div>

        <div class="form-group ">
            <div>
                <label for="nome">CPF</label>
                <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}"  required autocomplete="cpf" autofocus>

                @error('cpf')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>
        </div>

        <div class="form-group ">
            <div>
                <label for="telefone">Telefone</label>
                <input id="telefone" type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" value="{{ old('telefone') }}"  required autocomplete="telefone" autofocus>

                @error('telefone')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>
        </div>

        <div class="form-group ">
            <div>
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group ">
            <div>
                <label for="senha">Senha</label>
                <input id="senha" type="password" class="form-control @error('senha') is-invalid @enderror" name="senha" value="{{ old('senha') }}"  required autocomplete="senha" autofocus>

                @error('senha')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <!-- div com botao cadastrar -->
        <div class="form-group">
            <div>
                <button type="submit" >{{ __('Cadastrar') }}</button>
            </div>
        </div>


    </form>

</body>
</html>
