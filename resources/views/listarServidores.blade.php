@foreach($servidores as $servidor)
    {{$servidor->name}} -- {{$servidor->email}}<a href="{{route('enviarEmail',['id' => $servidor->id])}}"> Confirmar cadastro </a><br>
@endforeach
