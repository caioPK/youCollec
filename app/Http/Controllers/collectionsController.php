<?php

namespace App\Http\Controllers;


use App\Collection;
use App\Feed_Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class collectionsController extends Controller
{
    public function listaCat(){
        $cats = Collection::all()->sortBy('nomeCat');
        return view('categorias',['lista'=>$cats]);

    }

    public  function videosCat($id){
       $videos = Feed_Video::where('idCat', $id)->get();
       foreach ($videos as $video){
           $video->idVideo = 'http://www.youtube.com/embed/'.$video->idVideo;
       }

       return view('criando',['videos'=>$videos]);
    }
}
