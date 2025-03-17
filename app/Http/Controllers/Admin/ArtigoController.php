<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Arquivo;
use App\Models\Artigo;
use App\Models\Tema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArtigoController extends Controller
{
    private $artigo;    
    private $tema;
    private $arquivo;

    public function __construct(Artigo $artigo, Tema $tema, Arquivo $arquivo)
    {
        $this->artigo = $artigo;
        $this->tema = $tema;
        $this->arquivo = $arquivo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(is_null($request->pesquisa)){
            $artigos = $this->artigo->orderBy('id','DESC')->paginate(6);
        }else{
            $query = $this->artigo->query()
                         ->where('titulo','LIKE','%'.$request->pesquisa.'%');         
            $artigos = $query->orderBy('id','DESC')->paginate(6);
        }            
        return view('admin.artigo.index',[
            'artigos' => $artigos,         
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $temas = $this->tema->all('id','titulo');        
        return view('admin.artigo.create',[
            'temas' => $temas,
        ]);
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
            'titulo'    => ['required','max:100'],
            'descricao' => ['required','max:180'],
            'conteudo'  => ['required'],            
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
            $filePath = 'img/'.$fileName;
            $storagePath = public_path().'/storage/img/';
            $file->move($storagePath,$fileName);            

                   ///excluir imagem temporária      
                    $tempPath = public_path().'/storage/temp/'.$fileName;
                    if(file_exists($tempPath)){
                        unlink($tempPath);
                    }
           
            }

            $user = auth()->user();
            $data['titulo'] = $request->input('titulo');
            $data['descricao'] = $request->input('descricao');
            $data['conteudo'] = $request->input('conteudo');            
            if($filePath){
                $data['imagem'] = $filePath;
            }
            $data['user_id'] = $user->id;
            $data['created_at'] = now();
            $data['updated_at'] = null;
            $artigo = $this->artigo->create($data);

            $artigo->temas()->sync(json_decode($request->input('temas')));

            return response()->json([            
                'status' => 200,                
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
        $artigo = $this->artigo->find($id);
        $temas = $this->tema->all('id','titulo');        
        return view('admin.artigo.edit',[
            'temas' => $temas,
            'artigo' => $artigo,
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
            'titulo'    => ['required','max:100'],
            'descricao' => ['required','max:180'],
            'conteudo'  => ['required'],            
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $artigo = $this->artigo->find($id);
            $user = auth()->user();
            if($artigo){
                $filePath="";
                if($request->hasFile('imagem')){
                    //exclui a imagem antiga se houver
                    if($artigo->imagem){
                        $antigoPath = public_path().'/storage/'.$artigo->imagem;
                        if(file_exists($antigoPath)){
                            unlink($antigoPath);
                        }
                    }
                $file = $request->file('imagem');                           
                $fileName =  $file->getClientOriginalName();
                $filePath = 'img/'.$fileName;
                $storagePath = public_path().'/storage/img/';
                $file->move($storagePath,$fileName);      
                
                //excluir imagem temporária
                $tempPath = public_path().'/storage/temp/'.$fileName;
                        if(file_exists($tempPath)){
                            unlink($tempPath);
                        }
                }
                $data['titulo'] = $request->input('titulo');
                $data['descricao'] = $request->input('descricao');
                $data['conteudo'] = $request->input('conteudo');                
                if($filePath){
                    $data['imagem'] = $filePath;
                }
                $data['user_id'] = $user->id;
                $data['updated_at'] = now();

                $artigo->update($data); //atualização retorna um valor booleano
                $a = Artigo::find($id);
                $a->temas()->sync(json_decode($request->input('temas')));                

                return response()->json([                
                    'status' => 200,                    
                ]);

            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Artigo não localizado!',
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
        $artigo = $this->artigo->find($id);
        $t = $artigo->temas; //todos os temas são atribuídos à variável $t
        $artigo->temas()->detach($t); //exclui os dados de temas()
        if($artigo->imagem) //se tem imagem
        {
            ///deleção do arquivo de imagem no diretório
            $arquivoPath = public_path('/storage/'.$artigo->imagem);
            if(file_exists($arquivoPath)){
                unlink($arquivoPath);            
        }
        if($artigo->arquivos->count()){
            //deleção do arquivo na pasta /storage/arquivos/   
            foreach($artigo->arquivos as $arqs){ //percorre todos os arquivos relacionados
                $this->deleteArquivo($arqs->id);  //exclui o registro e o arquivo no diretório
            }
        }
        if($artigo->comentarios->count()>0) //se houver comentários
        {
            $comentarios = $artigo->comentarios;
            $artigo->comentarios()->delete($comentarios);
        }
        $artigo->delete();  //deleta o artigo

        return response()->json([
            'status' => 200,
            'message' => 'Artigo excluído com sucesso!',
        ]);
    }
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

    public function uploadDocs(Request $request, int $id){             
         if ($request->TotalFiles>0) 
         {
           $user = auth()->user();
           $arquivo = $this->arquivo->orderByDesc('id')->first();
           if($arquivo){
            $maxid = $arquivo->id;
           }else{
            $maxid = 0;
           }

           for($x = 0; $x < $request->TotalFiles; $x++) 
           {                                              
              if($request->hasFile('arquivo'.$x))
              {
                    $file = $request->file('arquivo'.$x);
                    $fileLabel = $file->getClientOriginalName();
                    $fileName = $id.'_'.$fileLabel;                        
                    $filePath = 'arquivos/'.$fileName;
                    $storagePath = public_path().'/storage/arquivos/';
                    $file->move($storagePath,$fileName);                                                 

                    $maxid++;
                    
                    $data[$x]['id'] = $maxid;
                    $data[$x]['user_id'] = $user->id;
                    $data[$x]['artigos_id'] = $id;                    
                    $data[$x]['rotulo'] = $fileLabel;
                    $data[$x]['nome'] = $fileName;
                    $data[$x]['path'] = $filePath;                    
                    $data[$x]['created_at'] = now();
                    $data[$x]['updated_at'] = null;
                } 
           }                      
             Arquivo::insert($data);                                                                  
         }    
             $artigo = $this->artigo->find($id);             
             $arquivos = $artigo->arquivos;
             return response()->json([
                 'artigo' => $artigo,                 
                 'arquivos' => $arquivos,
                 'status' => 200,                 
             ]);  

    }

    public function deleteDocs(int $id){        
            $arquivo = $this->arquivo->find($id);    
            $artigoid = $arquivo->artigos_id;
            //deleção do arquivo na pasta /storage/arquivos/   
            $arquivoPath = public_path('/storage/'.$arquivo->path);
            if(file_exists($arquivoPath)){
                unlink($arquivoPath);
            }    
            //excluir na tabela                             
            $arquivo->delete();
            $artigo = $this->artigo->find($artigoid);    
            return response()->json([
                'artigo' => $artigo,
                'status' => 200,                
            ]);        
    }

    public function abrirDoc(int $id){
        $arquivo = $this->arquivo->find($id);
        return response()->json([
            'status' => 200,
            'arquivo' => $arquivo,
        ]);
    }  

    public function deleteArquivo($id){        
        $arquivo = Arquivo::find($id);
        $artigoid = $arquivo->artigos_id;  
        //deleção o arquivo na pasta /storage/arquivos/   
        $arquivoPath = public_path('/storage/'.$arquivo->path);                    
        if(file_exists($arquivoPath)){
            unlink($arquivoPath);
        }    
        //excluir na tabela                             
        $arquivo->delete();
        $artigo = $this->artigo->find($artigoid);
        $totalarqs = $artigo->arquivos->count();
        return true;        
    }

}
