<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entidade;
use App\Models\Patrocinio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EntidadeController extends Controller
{

    private $entidade;
    private $patrocinio;

    public function __construct(Entidade $entidade, Patrocinio $patrocinio)
    {
        $this->entidade = $entidade;
        $this->patrocinio = $patrocinio;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$color)
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
            'color' => $color,
        ]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($color)
    {
        $patrocinios = $this->patrocinio->all('id','sigla');
        return view('admin.entidade.create',[
            'patrocinios' => $patrocinios,
            'color' => $color,
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
            $filePath="";
            if($request->hasFile('imagem')){
            $file = $request->file('imagem');                           
            $fileName =  $file->getClientOriginalName();                
            $filePath = 'entidade/'.$fileName;
            $storagePath = public_path().'/storage/entidade/';
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
            if($filePath){
                $data['logo'] = $filePath;
            }
            $data['fundacao'] = $request->input('fundacao');
            $data['cnpj'] = $request->input('cnpj');
            $data['endereco'] = $request->input('endereco');
            $data['numero'] = $request->input('numero');
            $data['bairro'] = $request->input('bairro');
            $data['cidade'] = $request->input('cidade');
            $data['cep'] = $request->input('cep');
            $data['estado'] = $request->input('estado');
            $data['created_at'] = now();
            $data['updated_at'] = null;

            $entidade = $this->entidade->create($data);
            $e = $entidade;

            $entidade->patrocinios()->sync(json_decode($request->input('patrocinios')));

            return response()->json([
                'entidade' => $e,
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
    public function edit($id,$color)
    {
        $entidade = $this->entidade->find($id);
        $patrocinios = $this->patrocinio->all('id','sigla');
        return view('admin.entidade.edit',[
            'status' => 200,
            'entidade' => $entidade,
            'patrocinios' => $patrocinios,
            'color' => $color,
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
            $entidade = $this->entidade->find($id);
            if($entidade){
                $filePath="";
                if($request->hasFile('imagem')){
                    //exclui a imagem antiga se houver
                    if($entidade->logo){
                        $antigoPath = public_path().'/storage/'.$entidade->logo;
                        if(file_exists($antigoPath)){
                            unlink($antigoPath);
                        }
                    }
                $file = $request->file('imagem');                           
                $fileName =  $file->getClientOriginalName();
                $filePath = 'entidade/'.$fileName;
                $storagePath = public_path().'/storage/entidade/';
                $file->move($storagePath,$fileName);      
                
                //excluir imagem temporária
                $tempPath = public_path().'/storage/temp/'.$fileName;
                        if(file_exists($tempPath)){
                            unlink($tempPath);
                        }
                }
                $data['nome'] = $request->input('nome');
                $data['sigla'] = $request->input('sigla');
                $data['fundacao'] = $request->input('fundacao');
                $data['cnpj'] = $request->input('cnpj');
                if($filePath){
                    $data['logo'] = $filePath;
                }
                $data['endereco'] = $request->input('endereco');
                $data['numero'] = $request->input('numero');
                $data['bairro'] = $request->input('bairro');
                $data['cidade'] = $request->input('cidade');
                $data['cep'] = $request->input('cep');
                $data['estado'] = $request->input('estado');                
                $data['updated_at'] = now();

                $entidade->update($data);
                $e = Entidade::find($id);
                $end = $e;
                $e->patrocinios()->sync(json_decode($request->input('patrocinios')));

                return response()->json([
                    'status' => 200,
                    'entidade' => $end,
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
        $entidade = $this->entidade->find($id);
        $patrocinios = $entidade->patrocinios;
        if($patrocinios->count){
            return response()->json([
                'status' => 400,
                'errors' => 'Este registro não pode ser excluído. Pois, há outros que dependem dele!',
            ]);
        }else{
         ///deleção do arquivo de imagem no diretório
              $arquivoPath = public_path('/storage/'.$entidade->logo);
              if(file_exists($arquivoPath)){
                  unlink($arquivoPath);            
          }
            $entidade->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Registro excluído com sucesso!',
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

    public function maxId(){
        $entidade = $this->entidade->orderByDesc('id')->first();
        if($entidade){
            $codigo = $entidade->id;
        }else{
            $codigo = 0;
        }
        return $codigo+1;
    }
}
