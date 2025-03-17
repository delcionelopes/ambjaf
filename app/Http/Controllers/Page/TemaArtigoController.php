<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Tema;
use Illuminate\Http\Request;

class TemaArtigoController extends Controller
{
    private $tema;

    public function __construct(Tema $tema)
    {
        $this->tema = $tema;
    }

    public function index($slug){

        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        
        $tema = $this->tema->whereSlug($slug)->first();
        $artigos = $tema->artigos()->paginate(5);
        return view('page.temas',[
            'tema' => $tema,
            'artigos' =>$artigos,
        ]);
    }
}
