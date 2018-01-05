@foreach($lista as $cat)
    <a href='categorias/{{$cat->idCat}}'>{{$cat->nomeCat}}</a><br>
@endforeach