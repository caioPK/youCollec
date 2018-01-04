<?php
namespace App\Http\Controllers;
use App\Channel;
use App\Collection;
use App\Feed_Video;
use App\XML;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;


class feedsController extends Controller
{
    //Retornando a view de upload de XML
    public function enviarXML()
    {
        return view('comecando');
    }


    //Fazendo o arquivamento e retorno do XML
    public function upload(Request $request)
    {
        //Arquivando XML no servidor e recuorando o path
        $path = $request->file('file')->store('xmls');

        //Criando registro do XML no banco de dados
        XML::create(
            [
                'idUser'=>Auth::user()->id,
                'filePath' => $path,
            ]
        );

        //Carregando arquivo em um objeto XML
        $file = Storage::get(DB::table('xmls')->where('idUser', Auth::user()->id)->value('filePath'));
        $xml = simplexml_load_string($file);

        //Encurtando a url para apenas o ID do canal no youtube
        foreach ($xml->body->outline->outline as $canal) {
            $urlCanal = str_replace("https://www.youtube.com/feeds/videos.xml?channel_id="
                , "", $canal[0]['xmlUrl']);

            //Alimentando tabela de canais
            Channel::create(
                [
                    'url' => $urlCanal,
                    'nomeCanal' => $canal[0]['text'],
                ]
            );
        }

        //retornando arquivo XML para gerenciamento
        return view('gerenciar',['xml'=>$xml]);
    }


    public function carregarCanais(){
        $file = Storage::get(DB::table('xmls')->where('idUser', Auth::user()->id)->value('filePath'));
        $xml = simplexml_load_string($file);
        return view('gerenciar',['xml'=>$xml]);
    }



    //Resposta do post da pagina de gerenciamento
    public function criando(Request $request)
    {
        //explode the string and assimilate to channels
        $lista = $request->input('hlista');
        $urls = explode('@',$lista);
        $canaisId = '';
        foreach ($urls as $url){
            $canal = DB::table('channels')->where('url', $url)->value('idCanal');
            $canaisId = $canaisId.",".$canal;
        }

        //Criando nova categoria com os canais by ID
        Collection::create(
            [
                'idUser'=>Auth::user()->id,
                'nomeCat' => $request->input('name'),
                'canaisId' =>$canaisId,
            ]
        );

        $name = $request->input('name');
        $feed = DB::table('collections')->where('nomeCat', $name)->value('canaisId');
        $idCat = DB::table('collections')->where('nomeCat', $name)->value('idCat');

        $listaCanal = explode(',',$feed);
        $index =2;
        for ($i=2;$i<sizeof($listaCanal);$i++){
                echo $canal;
                $urlCanal = DB::table('channels')->where('idCanal',$listaCanal[$i])->value('url');
                $urlCompleta = "http://www.youtube.com/feeds/videos.xml?channel_id=".$urlCanal;


                //recebe o xml do canal
            $xml = simplexml_load_file($urlCompleta);
            //pega o link de cada video
            foreach($xml->entry as $video){
                //$urlVideo recebe apenas o id do video
                $urlVideo = $video->id;
                $urlVideo = str_replace ("yt:video:", "", $urlVideo);
                Feed_Video::create(
                    [
                        'idVideo'=> $urlVideo,
                        'idUser' => Auth::user()->id,
                        'idCat' =>$idCat,
                        'assistido'=>false,
                        'idCanal'=>$listaCanal[$i],
                    ]

                );

            }


        }
    }



    //ALIMENTAR A TABELA DE VIDEOS
    public function alimentandoFeed(Request $request){
        //recebe os ids

    }
}
