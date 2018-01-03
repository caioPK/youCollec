@extends('layouts.app')

@section('content')
    <style CSS>
        .table-responsive {
            max-height: 300px;
        }
    </style>
    <div class="container">
        <div class="modal show">
            <div class="modal-dialog " >
               <div class="modal-content">
                   <div class="modal-body">
                       <div class="panel panel-default">
                       <div class="panel-heading">
                           Nova collection
                           <a class="pull-right" href="{{'/clientes/novo'}}">fechar</a>
                       </div>

                       <div class="panel-body " >

                           <form class="form-horizontal" method="POST" action="{{ url('criando') }}">
                               {{ csrf_field() }}
                               <input name="string" type="hidden" value="">
                               <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                   <label for="name" class="col-md-4 control-label">Nome da collection</label>

                                   <div class="col-md-6">
                                       <input id="name" type="text" class="form-control" placeholder="New collection" name="name" required autofocus>
                                       <input type="submit" onclick ="enviar()">
                                       <input type="hidden" name="lista" value="">
                                       @if ($errors->has('name'))
                                           <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                       @endif
                                   </div>
                               </div>
                           </form>



                           <table class="table " id="canais">
                               <thead>
                               <th>LISTA</th>
                               <th>ADICIONADOS</th>
                               </thead>
                               <TBODY>
                               <tr>
                                   <td>
                                       <table class="table ">
                                           <th>Nome</th>
                                           <tbody>
                                           @foreach($xml->body->outline->outline as $lista)
                                               <tr>
                                                   <td>{{$lista[0]['text']}}</td>
                                                   <td>
                                                       <button class="btn btn-sm" id="novocanal" onclick="this.disabled=true;insere('{{$xml->body->outline->outline[ $loop->index ]['xmlUrl']}}',
                                                                                                                '{{$xml->body->outline->outline[ $loop->index ]['text']}}')">Adicionar</button>

                                                   </td>
                                               </tr>
                                           @endforeach
                                           </tbody>
                                       </table>
                                   </td>
                                   <td>
                                       <div >
                                           <ul id="listCanal">
                                               <li >
                                                   <p id="listaurl"></p>
                                               </li>
                                           </ul>

                                       </div>
                                   </td>
                               </tr>

                               </TBODY>

                           </table>

                       </div>
                   </div>

               </div>

            </div>
        </div>
    </div>
        <script type="text/javascript">
            
            var arra=[];
            var listastring='';

            function enviar() {
                document.forms[0].lista.value = listastring;
            }
            function insere (a,b) {
                arra.push(a);
                listastring = listastring + "@" +a;
               document.getElementById("listaurl").innerHTML =listastring;
                var ul = document.getElementById("listCanal");
                var li = document.createElement("li");
                li.appendChild(document.createTextNode(b));
                ul.appendChild(li);
            }
        </script>
@endsection



