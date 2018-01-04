<?php
namespace App\Http\Controllers;
use App\Channel;
use App\Collection;
use App\XML;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;


class feedsController extends Controller
{

    public function upload(Request $request)
    {
        $path = $request->file('file')->store('xmls');
        XML::create(
            [
                'idUser'=>Auth::user()->id,
                'filePath' => $path,
            ]
        );
        $file = Storage::get(DB::table('xmls')->where('idUser', Auth::user()->id)->value('filePath'));
        $xml = simplexml_load_string($file);

        foreach ($xml->body->outline->outline as $canal) {
            $urlCanal = str_replace("https://www.youtube.com/feeds/videos.xml?channel_id="
                , "", $canal[0]['xmlUrl']);

            Channel::create(
                [
                    'url' => $urlCanal,
                    'nomeCanal' => $canal[0]['text'],
                ]
            );
        }
        return view('gerenciar',['xml'=>$xml]);
    }

    public function carregarCanais(){
        $file = Storage::get(DB::table('xmls')->where('idUser', Auth::user()->id)->value('filePath'));
        $xml = simplexml_load_string($file);
    return view('gerenciar',['xml'=>$xml]);
    }


    public function gerenciarXML()
    {
        return view('comecando');
    }


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

        Collection::create(
            [
                'idUser'=>Auth::user()->id,
                'nomeCat' => $request->input('name'),
                'canaisId' =>$canaisId,
            ]
        );
        $name = $request->input('name');
        $feed = DB::table('collections')->where('nomeCat', $name)->value('canaisId');
        return view('criando',['canais'=>$feed]);
    }
    }
