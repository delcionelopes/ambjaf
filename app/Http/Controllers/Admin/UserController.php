<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perfil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $user;
    private $perfil;

    public function __construct(User $user, Perfil $perfil)
    {
        $this->user = $user;
        $this->perfil = $perfil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(is_null($request->pesquisa)){
            $users = $this->user->orderByDesc('id')->paginate(6);
        }else{
            $query = $this->user->query()
                                ->where('name','LIKE','%'.$request->pesquisa.'%');
            $users = $query->orderByDesc('id')->paginate(6);
        }
        return view('admin.user.index',[
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $perfis = $this->perfil->orderByDesc('id')->get();
        return view('admin.user.create',[
            'perfis' => $perfis,
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
            'name' => ['required','max:100'],
            'email' => ['required','email','max:100','unique:users'],
            'password' => ['required','min:8','max:100'],
            'cpf' => ['required','cpf','max:14'],
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
                $filePath = 'avatar/'.$fileName;
                $storagePath = public_path().'/storage/avatar/';
                $file->move($storagePath,$fileName);
            }

            //excluir imagem temporária se existir
            $tempPath = public_path().'/storage/temp/'.$fileName;
            if(file_exists($tempPath)){
                unlink($tempPath);
            }
            $data['id'] = $this->maxId();
            $data['name'] = strtoupper($request->input('name'));
            $data['perfil_id'] = $request->input('perfil_id');
            $data['email'] = $request->input('email');
            $data['password'] = bcrypt($request->input('password'));            
            $data['admin'] = $request->input('admin');
            $data['inativo'] = false;
            if($filePath!=""){
                $data['avatar'] = $filePath;
            }            
            $data['cpf'] = $this->deixaSomenteDigitos($request->input('cpf'));
            $data['endereco'] = strtoupper($request->input('endereco'));
            $data['numero'] = strtoupper($request->input('numero'));
            $data['bairro'] = strtoupper($request->input('bairro'));
            $data['cidade'] = strtoupper($request->input('cidade'));
            $data['cep'] = $request->input('cep');
            $data['estado'] = $request->input('estado');
            $data['link_instagram'] = $request->input('link_instagram');
            $data['link_facebook'] = $request->input('link_facebook');
            $data['link_site'] = $request->input('link_site');
            $data['created_at'] = now();
            $data['updated_at'] = null;

            $user = $this->user->create($data);

            return response()->json([
                'user' => $user,
                'status' => 200,
                'message' => 'Usuário criado com sucesso!',
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
        $user = $this->user->find($id);
        $perfis = $this->perfil->orderByDesc('id')->get();
        return view('admin.user.edit',[
            'user' => $user,
            'perfis' => $perfis,
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
            'name' => ['required','max:100'],
            'cpf' => ['required','cpf','max:14'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->getMessages(),
            ]);
        }else{
            $user = $this->user->find($id);
            if($user){
                    $filePath = "";
                    if($request->hasFile('imagem')){
                        $file = $request->file('imagem');
                        //exclui a imagem de avatar anterior se houver
                        if($user->avatar){
                            $antigoPath = public_path().'/storage/'.$user->avatar;
                            if(file_exists($antigoPath)){
                                unlink($antigoPath);
                            }
                        }
                        //upload do novo arquivo
                        $fileNameOriginal = $file->getClientOriginalName();
                        $fileName = $id.'_'.$file->getClientOriginalName();
                        $filePath = 'avatar/'.$fileName;
                        $storagePath = public_path().'/storage/avatar/';
                        $file->move($storagePath,$fileName);

                        //excluir imagem temporária se existir
                        $tempPath = public_path().'/storage/temp/'.$fileNameOriginal;
                        if(file_exists($tempPath)){
                            unlink($tempPath);
                        }
                    }                    

                    $data['name'] = strtoupper($request->input('name'));
                    $data['perfil_id'] = $request->input('perfil_id');
                    $data['email'] = $request->input('email');
                    if($request->password){
                    $data['password'] = bcrypt($request->input('password'));
                    }                    
                    $data['admin'] = $request->input('admin');
                    $data['inativo'] = $request->input('inativo');
                    if($filePath!=""){
                        $data['avatar'] = $filePath;
                    }
                    $data['cpf'] = $this->deixaSomenteDigitos($request->input('cpf'));
                    $data['endereco'] = strtoupper($request->input('endereco'));
                    $data['numero'] = strtoupper($request->input('numero'));
                    $data['bairro'] = strtoupper($request->input('bairro'));
                    $data['cidade'] = strtoupper($request->input('cidade'));
                    $data['cep'] = $request->input('cep');
                    $data['estado'] = $request->input('estado');
                    $data['link_instagram'] = $request->input('link_instagram');
                    $data['link_facebook'] = $request->input('link_facebook');
                    $data['link_site'] = $request->input('link_site');                    
                    $data['updated_at'] = now();                    

                    $user->update($data);
                    $u = User::find($id);

                    return response()->json([
                        'user' => $u,
                        'status' => 200,
                        'message' => 'Usuário atualizado com sucesso!',
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
        $user = $this->user->find($id);
        //exclusão do arquivo do avatar se houver
        if($user->avatar){
            $avatarPath = public_path('/storage/'.$user->avatar);
            if(file_exists($avatarPath)){
                unlink($avatarPath);
            }
        }
        //exclusão dos comentários
        $comentarios = $user->comentarios;
        $user->comentarios()->delete($comentarios);
        //exclusão dos arquivos pdf
        $arquivos = $user->arquivos;
             foreach($arquivos as $arq){
                 $arqPath = public_path('/storage/'.$arq->path);
                 if(file_exists($arqPath)){
                     unlink($arqPath);
                 }
             }
        $user->arquivos()->delete($arquivos);
        //exclusão dos artigos
        $artigos = $user->artigos;              
              foreach($artigos as $art){
        //exclusão os arquivos de capa dos artigos se houver
                  if($art->imagem){
                  $capaPath = public_path('/storage/'.$art->imagem);
                  if(file_exists($capaPath)){
                      unlink($capaPath);
                  }
                }
                //exclusão da relação com os temas se houver
                $temas = $art->temas;
                if($temas){
                $art->temas()->detach($temas);
                }
              }              
        $user->artigos()->delete($artigos);
        //Exclusão do usuário
        $user->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Registro excluído com sucesso!',
        ]);
    }

    public function inativoUsuario(Request $request, int $id){
        $inativo = $request->input('inativo');
        $data = ['inativo' => $inativo];
        $user = $this->user->find($id);
        $user->update($data);
        $u = User::find($id);
        return response()->json([
            'user' => $u,
            'status'=> 200,
        ]);
    }

    public function adminUsuario(Request $request,int $id){
        $user = $this->user->find($id);
        $admin = $request->input('admin');
        $data = ['admin' => $admin];        
        $user->update($data);
        $u = User::find($id);
        return response()->json([
            'user' => $u,
            'status'=> 200,
        ]);
    }

    public function fotoTempUpload(Request $request){
        $validator = Validator::make($request->all(),[
             'imagem' => 'required',
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

    public function deleteFotoTemp(Request $request){
         //exclui o arquivo temporário se houver
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

    protected function deixaSomenteDigitos($input){
        return preg_replace('/[^0-9]/','',$input);
    }

    public function maxId(){
        $user = $this->user->orderByDesc('id')->first();
        if($user){
            $codigo = $user->id;
        }else{
            $codigo=0;
        }
        return $codigo++;
    }
    

}
