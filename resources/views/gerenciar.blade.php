---------pagina gerenciar

@foreach($xml->body->outline->outline as $lista)
    {{$lista[0]['text']}}
    <br>
@endforeach

