<?php

use App\Http\Controllers\Admin\ArtigoController;
use App\Http\Controllers\Admin\EntidadeController;
use App\Http\Controllers\Admin\PatrocinioController;
use App\Http\Controllers\Admin\TemaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Caos\ModuloController;
use App\Http\Controllers\Caos\OperacaoController;
use App\Http\Controllers\Caos\PerfilController;
use App\Http\Controllers\Caos\PrincipalController;
use App\Http\Controllers\Caos\SegurancaController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
}); */

Auth::routes();

Route::get('/home', [App\Http\Controllers\Page\HomeController::class, 'master'])->name('home');

Route::group(['middleware' => ['auth']],function(){

//Admin
Route::prefix('admin')->name('admin.')->group(function(){

    //rotas para os artigos
    Route::prefix('artigos')->name('artigos.')->group(function(){
        Route::get('/index/{color}',[ArtigoController::class,'index'])->name('index');
        Route::get('/create/{color}',[ArtigoController::class,'create'])->name('create');
        Route::delete('/delete/{id}',[ArtigoController::class,'destroy']);
        Route::get('/edit/{id}/{color}',[ArtigoController::class,'edit'])->name('edit');
        Route::put('/update/{id}',[ArtigoController::class,'update']);
        Route::put('/store',[ArtigoController::class,'store']);
        Route::put('/imagemtemp-upload',[ArtigoController::class,'armazenarImagemTemporaria']);
        Route::delete('/delete-imgtemp',[ArtigoController::class,'excluirImagemTemporaria']);
        Route::put('/upload-docs/{id}',[ArtigoController::class,'uploadDocs']);
        Route::delete('/delete-docs/{id}',[ArtigoController::class,'deleteDocs']);
        Route::get('/abrir-doc/{id}',[ArtigoController::class,'abrirDoc']);
    });

    //rotas para os temas
    Route::prefix('tema')->name('tema.')->group(function(){
        Route::get('/index/{color}',[TemaController::class,'index'])->name('index');
        Route::put('/store',[TemaController::class,'store']);
        Route::get('/edit/{id}',[TemaController::class,'edit']);
        Route::put('/update/{id}',[TemaController::class,'update']);
        Route::delete('/delete/{id}',[TemaController::class,'destroy']);
    });

    //rotas para os usuários
    Route::prefix('user')->name('user.')->group(function(){
        Route::get('/index',[UserController::class,'index'])->name('index');
        Route::get('/create',[UserController::class,'create'])->name('create');
        Route::put('/store',[UserController::class,'store']);
        Route::get('/edit/{id}',[UserController::class,'edit'])->name('edit');
        Route::put('/update/{id}',[UserController::class,'update']);
        Route::delete('/delete/{id}',[UserController::class,'destroy']);
        Route::put('/inativo/{id}',[UserController::class,'inativoUsuario']);
        Route::put('/admin/{id}', [UserController::class,'adminUsuario']);
        Route::put('/fototemp-upload',[UserController::class,'fotoTempUpload']);
        Route::delete('/delete-fototemp',[UserController::class,'deleteFotoTemp']);
    });

    //rotas para os patrocinios
    Route::prefix('patrocinios')->name('patrocinios.')->group(function(){
      Route::get('/index/{color}',[PatrocinioController::class,'index'])->name('index');
      Route::get('/create/{color}',[PatrocinioController::class,'create'])->name('create');
      Route::delete('/delete/{id}',[PatrocinioController::class,'destroy']);
      Route::get('/edit/{id}/{color}',[PatrocinioController::class,'edit'])->name('edit');
      Route::put('/update/{id}',[PatrocinioController::class,'update']);
      Route::put('/store',[PatrocinioController::class,'store']);
      Route::put('/imagemtemp-upload',[PatrocinioController::class,'armazenarImagemTemporaria']);
      Route::delete('/delete-imgtemp',[PatrocinioController::class,'excluirImagemTemporaria']);
  });

  //rotas para os entidades
  Route::prefix('entidades')->name('entidades.')->group(function(){
    Route::get('/index/{color}',[EntidadeController::class,'index'])->name('index');
    Route::get('/create/{color}',[EntidadeController::class,'create'])->name('create');
    Route::delete('/delete/{id}',[EntidadeController::class,'destroy']);
    Route::get('/edit/{id}/{color}',[EntidadeController::class,'edit'])->name('edit');
    Route::put('/update/{id}',[EntidadeController::class,'update']);
    Route::put('/store',[EntidadeController::class,'store']);
    Route::put('/imagemtemp-upload',[EntidadeController::class,'armazenarImagemTemporaria']);
    Route::delete('/delete-imgtemp',[EntidadeController::class,'excluirImagemTemporaria']);
});

}); //fim do grupo admin

    Route::prefix('meublogadmin')->name('meublogadmin.')->group(function(){
        Route::prefix('meublog')->name('meublog.')->group(function(){
            Route::get('/index',[HomeController::class,'index'])->name('index');
        });
    });

    Route::prefix('caos')->name('caos.')->group(function(){
        Route::prefix('modulo')->name('modulo.')->group(function(){
        Route::get('/index-modulo',[ModuloController::class,'index'])->name('index');
        Route::get('/create-modulo',[ModuloController::class,'create'])->name('create');
        Route::delete('/delete-modulo/{id}',[ModuloController::class,'destroy']);
        Route::get('/edit-modulo/{id}',[ModuloController::class,'edit'])->name('edit');
        Route::put('/update-modulo/{id}',[ModuloController::class,'update']);
        Route::put('/store-modulo',[ModuloController::class,'store'])->name('store');
        Route::put('/moduloimagemtemp-upload',[ModuloController::class,'armazenarImagemTemporaria']);        
        Route::delete('/delete-imgmodulo',[ModuloController::class,'excluirImagemTemporaria']);
        Route::get('/modulo-operacao/{operacao_id}',[ModuloController::class,'modulosXoperacoes'])->name('moduloxoperacao');
        });

        Route::prefix('operacao')->name('operacao.')->group(function(){
        Route::get('/index-operacao',[OperacaoController::class,'index'])->name('index');
        Route::get('/create-operacao',[OperacaoController::class,'create'])->name('create');
        Route::delete('/delete-operacao/{id}',[OperacaoController::class,'destroy']);
        Route::get('/edit-operacao/{id}',[OperacaoController::class,'edit'])->name('edit');
        Route::put('/update-operacao/{id}',[OperacaoController::class,'update']);
        Route::put('/store-operacao',[OperacaoController::class,'store'])->name('store');
        Route::put('/operacaoimagemtemp-upload',[OperacaoController::class,'armazenarImagemTemporaria']);        
        Route::delete('/delete-imgoperacao',[OperacaoController::class,'excluirImagemTemporaria']);
        Route::get('/operacao-modulo/{modulo_id}',[OperacaoController::class,'operacoesXmodulos'])->name('operacaoxmodulo');
      }); 

      Route::prefix('seguranca')->name('seguranca.')->group(function(){
        Route::get('/index-seguranca',[SegurancaController::class,'index_seguranca'])->name('index');
      });

      Route::prefix('principal')->name('principal.')->group(function(){   //navegação módulos autorizados
        Route::get('/index',[PrincipalController::class,'index'])->name('index'); //módulos
        Route::get('/operacoes/{id}',[PrincipalController::class,'operacoes'])->name('operacoes');  //operações
      });
      
      Route::prefix('perfil')->name('perfil.')->group(function(){
        Route::get('/index-perfil',[PerfilController::class,'index'])->name('index');        
        Route::delete('/delete-perfil/{id}',[PerfilController::class,'destroy']);
        Route::get('/edit-perfil/{id}',[PerfilController::class,'edit'])->name('edit');
        Route::put('/update-perfil/{id}',[PerfilController::class,'update']);
        Route::put('/store-perfil',[PerfilController::class,'store'])->name('store');
        Route::get('/list-authorizations/{id}',[PerfilController::class,'listAuthorizations']);
        Route::put('/store-authorizations/{id}',[PerfilController::class,'storeAuthorizations']); 
      }); 
    }); //fim do grupo CAOS


}); //fim do grupo middleware auth


    Route::namespace('App\Http\Controllers\Page')->name('page.')->group(function(){
    Route::get('/','HomeController@master')->name('master');
    Route::get('/artigo/{slug}','HomeController@detail')->name('detail');
    Route::get('/download-arquivo/{id}','HomeController@downloadArquivo')->name('download');
    Route::get('/tema/{slug}','TemaArtigoController@index')->name('tema');
    Route::get('/show-perfil/{id}','HomeController@showPerfil')->name('showperfil');
    Route::put('/perfil/{id}','HomeController@perfilUsuario')->name('perfil');
    Route::put('/fototemp-upload','HomeController@fotoTempUpload');
    Route::delete('/delete-fototemp','HomeController@deleteFotoTemp');
    Route::post('/salvar-comentario','ComentarioController@salvarComentario');
    Route::delete('/delete-comentario/{id}','ComentarioController@deleteComentario');    
  });


  Route::get('/cep/{cep}', function ($cep)
  {    
     $cep = strval($cep);
     $link = 'http://viacep.com.br/ws/'.$cep.'/json/';
    
     $url = sprintf($link);     

     $json = json_decode(file_get_contents($url), true);

     return response()->json([
      'status'=>200,
      'localizacao' => $json,
    ]);
  });