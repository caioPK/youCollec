@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @if(Auth::guest())
                        Você deve logar primeiro.
                    @else
                        <div class="panel-heading">Gerenciar incrições</div>
                        <form action="{{url('comecando')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="file" name="file"/>
                            <input type="submit">
                        </form>


                        <div class="panel-body">
                    @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
