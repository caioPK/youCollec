@foreach($videos as $link)
    <iframe src='{{$link->idVideo}}' allowfullscreen>
    </iframe><br>

@endforeach
