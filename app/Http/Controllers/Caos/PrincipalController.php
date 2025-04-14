<?php

namespace App\Http\Controllers\Caos;

use App\Http\Controllers\Controller;
use App\Models\Autmodope;
use App\Models\Modulo;
use App\Models\Operacao;
use Illuminate\Http\Request;

class PrincipalController extends Controller
{
    private $modulo;
    private $operacao;
    private $autorizacao;

    public function __construct(Modulo $modulo, Operacao $operacao, Autmodope $autorizacao)
    {
        $this->modulo = $modulo;
        $this->operacao = $operacao;
        $this->autorizacao = $autorizacao;
    }

    public function index(Request $request){
        $user = auth()->user();        
        $autorizacao = $this->autorizacao->query()
                                ->wherePerfil_id($user->perfil_id)
                                ->get();       
        $modulos = $this->modulo->all();
        return view('caos.principal.index',[
            'autorizacao' => $autorizacao,
            'modulos' => $modulos,
        ]);
    }

    public function operacoes(Request $request, int $id,$color){        
        $user = auth()->user();        
        $autorizacao = $this->autorizacao->query()
                                ->wherePerfil_id($user->perfil_id)
                                ->whereModope_modulo_id($id)
                                ->get();       
        $operacoes = $this->operacao->all();
        return view('caos.secondary.index',[
            'autorizacao' => $autorizacao,
            'operacoes' => $operacoes,
            'color' => $color,
        ]);
    }
}
