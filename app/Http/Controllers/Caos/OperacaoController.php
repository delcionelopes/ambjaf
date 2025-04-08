<?php

namespace App\Http\Controllers\Caos;

use App\Http\Controllers\Controller;
use App\Models\Modulo;
use App\Models\Operacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OperacaoController extends Controller
{
    private $operacao;
    private $modulo;

    public function __construct(Operacao $operacao, Modulo $modulo)
    {
        $this->operacao = $operacao;
        $this->modulo = $modulo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(is_null($request->pesquisa)){
            $operacoes = $this->operacao->orderByDesc('id')->paginate(6);
        }else{
            $query = $this->operacao->query()
                          ->where('nome','LIKE','%'.$request->pesquisa.'%');
            $operacoes = $query->orderByDesc('id')->paginate(6);
        }        
        return view('caos.operacao.index',[
            'operacoes' => $operacoes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('caos.operacao.create');
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
            'nome' => ['required','max:40'],
            'descricao' => ['required','max:200'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $filePath = "";
            if($request->hasFile('imagem')){
                $file = $request->file('imagem');
                $fileName = $file->getClientOriginalName();
                $filePath = 'ico_operacao/'.$fileName;
                $storagePath = public_path().'/storage/ico_operacao/';
                $file->move($storagePath,$fileName);

                //excluir imagem temporária
                $tempPath = public_path().'/storage/temp/'.$fileName;
                if(file_exists($tempPath)){
                    unlink($tempPath);
                }

            }

            $data['id'] = $this->maxId();
            $data['nome'] = $request->input('nome');
            $data['descricao'] = $request->input('descricao');
            if($filePath){
                $data['ico'] = $filePath;
            }
            $data['created_at'] = now();
            $data['updated_at'] = null;

            $operacao = $this->operacao->create($data);

            return response()->json([
                'status' => 200,
                'operacao' => $operacao,
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
        $operacao = $this->operacao->find($id);
        return view('caos.operacao.edit',[
            'operacao' => $operacao,
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
            'nome' => ['required','max:40'],
            'descricao' => ['required','max:200'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $operacao = $this->operacao->find($id);
            if($operacao){
            $filePath = "";
            if($request->hasFile('imagem')){

                //se houver imagem nova, exclui a imagem antiga se houver
                if($operacao->ico){
                    $antigoPath = public_path().'/storage/'.$operacao->ico;
                    if(file_exists($antigoPath)){
                        unlink($antigoPath);
                    }
                }

                //carrega a imagem nova
                $file = $request->file('imagem');
                $fileName = $file->getClientOriginalName();
                $filePath = 'ico_operacao/'.$fileName;
                $storagePath = public_path().'/storage/ico_operacao/';
                $file->move($storagePath,$fileName);

                //excluir imagem temporária
                $tempPath = public_path().'/storage/temp/'.$fileName;
                if(file_exists($tempPath)){
                    unlink($tempPath);
                }

            }
            
            $data['nome'] = $request->input('nome');
            $data['descricao'] = $request->input('descricao');
            if($filePath){
                $data['ico'] = $filePath;
            }            
            $data['updated_at'] = now();

            $operacao->update($data);

            $ope = Operacao::find($id);

            return response()->json([
                'status' => 200,
                'operacao' => $ope,
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Registro não localizado!',
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
        $operacao = $this->operacao->find($id);
        $modulos = $operacao->modulos;
        $autorizacoes = $operacao->autorizacao->count();

        if($autorizacoes){
            return response()->json([
                'status' => 400,
                'errors' => 'Esta operação não pode ser excluída! Pois há autorizações que dependem dela.',
            ]);
        }
        
        if($operacao->modulos->count()){
            $operacao->modulos()->detach($modulos);
        }
        //exclui imagem do diretório ico_operacao
        if($operacao->ico){
            $filePath = public_path().'/storage/'.$operacao->ico;
            if(file_exists($filePath)){
                unlink($filePath);
            }
        }

        $operacao->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }

    protected function maxId(){
        $operacao = $this->operacao->orderByDesc('id')->first();
        if($operacao){
            $codigo = $operacao->id;
        }else{
            $codigo = 0;
        }
        return $codigo+1;
    }

    public function armazenarImagemTemporaria(Request $request){
        $validator = Validator::make($request->all(),[
            'imagem' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $filePath = "";
            if($request->hasFile('imagem')){
                $file = $request->file('imagem');
                $fileName = $file->getClientOriginalName();
                $storagePath = public_path().'/storage/temp/';
                $filePath = 'storage/temp/'.$fileName;
                $file->move($storagePath,$fileName);
            }

            return response()->json([
                'status' => 200,
                'filepath' => $filePath,
            ]);
        }
    }

    public function excluirImagemTemporaria(Request $request){
        //exclui o arquivo temporário se houver
        if($request->hasFile('imagem')){
            $file = $request->file('imagem');
            $fileName = $file->getClientOriginalName();
            $antigoPath = public_path().'/storage/temp/'.$fileName;
            if(file_exists($antigoPath)){
                unlink($antigoPath);
            }
        }
        return response()->json([
            'status' => 200,
        ]);
    }

        public function operacoesXmodulos(int $modulo_id){
        $modulo = $this->modulo->whereId($modulo_id)->first();
        $operacoes = $modulo->operacoes()->paginate(6);
        return view('caos.operacao.index_operacaoXmodulos',[
            'operacoes' => $operacoes,
        ]);
    }


}
