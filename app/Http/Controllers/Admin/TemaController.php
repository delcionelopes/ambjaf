<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TemaController extends Controller
{
    private $tema;

    public function __construct(Tema $tema)
    {
        $this->tema = $tema;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$color)
    {
        if(is_null($request->pesquisa)){
            $temas = $this->tema->orderByDesc('id')->paginate(6);
        }else{
            $query = $this->tema->query()
                          ->where('titulo','LIKE','%'.$request->pesquisa.'%');
            $temas = $query->orderByDesc('id')->paginate(6);
        }

        return view('admin.tema.index',[
            'temas' => $temas,
            'color' => $color,
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
            'titulo' => ['required','max:100'],
            'descricao' => ['required','max:180'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $data['id'] = $this->maxId();
            $data['titulo'] = $request->input('titulo');
            $data['descricao'] = $request->input('descricao');            
            $data['created_at'] = now();  //atribuição explícita da data atual
            $data['updated_at'] = null;  //anulação explícita

            $tema = $this->tema->create($data);  //registro criado

            return response()->json([
                'tema' => $tema,
                'status' => 200,
                'message' => 'Registro criado com sucesso!',
            ]);

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
    public function edit(int $id)
    {
        $tema = $this->tema->find($id);
        return response()->json([
            'tema' => $tema,
            'status' => 200,            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(),[
            'titulo' => ['required','max:100'],
            'descricao' => ['required','max:180'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $tema = $this->tema->find($id);
            if($tema){
                $data['titulo'] = $request->input('titulo');
                $data['descricao'] = $request->input('descricao');                
                $data['updated_at'] = now();
                $tema->update($data); //retorna um valor booleano
                $t = Tema::find($id); //registro atualizado

                return response()->json([
                    'tema' => $t,
                    'staus' => 200,
                    'message' => 'Registro atualizado com sucesso!',
                ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Registro nãop localizado!',
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $tema = $this->tema->find($id);
        $artigos = $tema->artigos;

        if($tema->artigos->count()){
            $tema->artigos()->detach($artigos);
        }

        $tema->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }

    public function maxId(){
        $tema = $this->tema->orderByDesc('id')->first();
        if($tema){
            $codigo = $tema->id;
        }else{
            $codigo = 0;
        }
        return $codigo+1;
    }

}
