<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patrocinio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatrocinioController extends Controller
{
    private $patrocinio;

    public function __construct(Patrocinio $patrocinio)
    {
        $this->patrocinio = $patrocinio;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(is_null($request->pesquisa)){
            $patrocinios = $this->patrocinio->orderByDesc('id')->get();
        }else{
            $query = $this->patrocinio->query()
                          ->where('nome','LIKE','%'.$request->pesquisa.'%');
            $patrocinios = $query->orderByDesc('id')->get();
        }
        return view('admin.patrocinio.index',[
            'patrocinios' => $patrocinios,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.patrocinio.create');
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
            'nome' => ['required','max:30'],
            'sigla' => ['required','max:15'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $filePath="";
            if($request->hasFile('imagem')){
            $file = $request->file('imagem');                           
            $fileName =  $file->getClientOriginalName();                
            $filePath = 'patrocinio/'.$fileName;
            $storagePath = public_path().'/storage/patrocinio/';
            $file->move($storagePath,$fileName);            

                   ///excluir imagem temporária      
                    $tempPath = public_path().'/storage/temp/'.$fileName;
                    if(file_exists($tempPath)){
                        unlink($tempPath);
                    }
            }

            $data['id'] = $this->maxId();
            $data['nome'] = $request->input('nome');
            $data['sigla'] = $request->input('sigla');
            $data['cnpj'] = $request->input('cnpj');
            $data['cpf'] = $request->input('cpf');
            if($filePath){
                $data['logo'] = $filePath;
            }
            $data['link_site'] = $request->input('link_site');
            $data['email'] = $request->input('email');
            $data['contato'] = $request->input('contato');
            $data['endereco'] = $request->input('endereco');
            $data['inativo'] = false;
            $data['numero'] = $request->input('numero');
            $data['bairro'] = $request->input('bairro');
            $data['cidade'] = $request->input('cidade');
            $data['estado'] = $request->input('estado');
            $data['cep'] = $request->input('cep');
            $data['created_at'] = now();
            $data['updated_at'] = null;

            $patrocinio = $this->patrocinio->create($data);

            return response()->json([
                'status' => 200,
                'patrocinio' => $patrocinio,
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
    public function edit($id)
    {
        $patrocinio = $this->patrocinio->find($id);
        return view('admin.patrocinio.edit',[
            'status' => 200,
            'patrocinio' => $patrocinio,
        ]);
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
        $validator = Validator::make($request->all(),[
            'nome' => ['required','max:30'],
            'sigla' => ['required','max:15'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $patrocinio = $this->patrocinio->find($id);
            if($patrocinio){
                $filePath="";
                if($request->hasFile('imagem')){
                    //exclui a imagem antiga se houver
                    if($patrocinio->logo){
                        $antigoPath = public_path().'/storage/'.$patrocinio->logo;
                        if(file_exists($antigoPath)){
                            unlink($antigoPath);
                        }
                    }
                $file = $request->file('imagem');                           
                $fileName =  $file->getClientOriginalName();
                $filePath = 'patrocinio/'.$fileName;
                $storagePath = public_path().'/storage/patrocinio/';
                $file->move($storagePath,$fileName);      
                
                //excluir imagem temporária
                $tempPath = public_path().'/storage/temp/'.$fileName;
                        if(file_exists($tempPath)){
                            unlink($tempPath);
                        }
                }         
            
            $data['nome'] = $request->input('nome');
            $data['sigla'] = $request->input('sigla');
            if($filePath){
                $data['logo'] = $filePath;
            }
            $data['link_site'] = $request->input('link_site');
            $data['email'] = $request->input('email');
            $data['contato'] = $request->input('contato');
            $data['endereco'] = $request->input('endereco');
            $data['inativo'] = $request->input('inativo');
            $data['cnpj'] = $request->input('cnpj');
            $data['cpf'] = $request->input('cpf');
            $data['numero'] = $request->input('numero');
            $data['bairro'] = $request->input('bairro');
            $data['cidade'] = $request->input('cidade');
            $data['estado'] = $request->input('estado');
            $data['cep'] = $request->input('cep');
            $data['created_at'] = now();
            $data['updated_at'] = null;

            $patrocinio = $this->patrocinio->update($data);

            $p = Patrocinio::find($id);

            return response()->json([
                'status' => 200,
                'patrocinio' => $p,
                'message' => 'Registro alterado com sucesso!',                
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
    public function destroy($id)
    {
        $patrocinio = $this->patrocinio->find($id);
        $entidades = $patrocinio->entidades;
        $artigos = $patrocinio->artigos;
        if($entidades->count()){
            return response()->json([
                'status' => 400,
                'errors' => 'Este registro não pode ser excluído. Pois, há entidades que dependem dele!',
            ]);
        }
        if($artigos->count()){
            return response()->json([
                'status' => 400,
                'errors' => 'Este registro não pode ser excluído. Pois, há artigos, programas ou projetos que dependem dele!',
            ]);
        }
        ///deleção do arquivo de imagem no diretório se existir
        $arquivoPath = public_path('/storage/'.$patrocinio->logo);
        if(file_exists($arquivoPath)){
            unlink($arquivoPath);            
    }
        $patrocinio->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }

    public function armazenarImagemTemporaria(Request $request){
        if($request->hasFile('imagem')){
        $file = $request->file('imagem');                           
        $fileName =  $file->getClientOriginalName();        
        $storagePath = public_path().'/storage/temp/';
        $filePath = 'storage/temp/'.$fileName;
        $file->move($storagePath,$fileName);            
        }
        return response()->json([
            'status' => 200,
            'filepath' => $filePath,
        ]);        
}


 public function excluirImagemTemporaria(Request $request){
     //exclui a imagem temporária no diretório se houver
            if($request->hasFile('imagem')){
                $file = $request->file('imagem');
                $filename = $file->getClientOriginalName();
                $antigoPath = public_path().'/storage/temp/'.$filename;
                if(file_exists($antigoPath)){
                    unlink($antigoPath);
                }
            }     
    return response()->json([
        'status' => 200,            
    ]);
}

    protected function maxId(){
        $patrocinio = $this->patrocinio->orderByDesc('id')->first();
        if($patrocinio){
            $codigo = $patrocinio->id;
        }else{
            $codigo = 0;
        }
        return $codigo++;
    }
}
