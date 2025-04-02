<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EntidadeController extends Controller
{

    private $entidade;

    public function __construct(Entidade $entidade)    
    {
        $this->entidade = $entidade;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(is_null($request->pesquisa)){
            $entidades = $this->entidade->orderBy('id','DESC')->paginate(6);
        }else{
            $query = $this->entidade->query()
                          ->where('nome','LIKE','%'.$request->pesquisa.'%');
            $entidades = $query->orderBy('id','DESC')->paginate(6);
        }
        return view('admin.entidade.index',[
            'entidades' => $entidades,
        ]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nome'     => ['required','max:30'],
            'sigla'    => ['required','max:15'],
            'fundacao' => ['required','date'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $data['id'] = $this->maxId();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function maxId(){
        $entidade = $this->entidade->orderByDesc('id')->first();
        if($entidade){
            $codigo = $entidade->id;
        }else{
            $codigo = 0;
        }
        return $codigo++;
    }
}
