<?php

namespace App\Http\Controllers\Caos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SegurancaController extends Controller
{
    public function index_seguranca(){
        return view('caos.seguranca.index');
    }
}
