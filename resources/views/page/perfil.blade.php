@extends('layouts.page')
@section('content')

<!-- Cabeçalho-->
<header class="masthead" style="background-image: url('/assets/img/home-bg.jpg')">
            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="site-heading">
                            <h1>Seja bem-vindo!</h1>
                            <span class="subheading">Personalize o seu perfil</span>
                        </div>
                    </div>
                </div>
            </div>
</header>
<div class="container px-4 px-lg-5">

<form role="form" enctype="multipart/form-data" method="POST">
    @csrf
    @method('PUT')
    <ul id="saveform_errList"></ul>
    <input type="hidden" id="edit_user_id" value="{{$user->id}}">
    <input type="hidden" id="edit_moderador" value="{{$user->moderador}}">
    <input type="hidden" id="edit_inativo" value="{{$user->inativo}}">
    <div class="container-fluid py-5">
        <div class="card">
            <div class="card-body">
              <div class="card p-3" style="background-image: url('/assets/img/banner-docs.jpg')">
                <div class="d-flex align-items-center">
                    <!--arquivo de imagem-->
                    <div class="form-group mb-3">                                                
                       <div class="image">
                        @if($user->avatar)
                            <img src="{{asset('storage/'.$user->avatar)}}" class="imgfoto rounded-circle" width="100" >
                        @else
                            <img src="{{asset('storage/user.png')}}" class="imgfoto rounded-circle" width="100">
                        @endif
                        </div>
                       <label for="">Foto</label>                        
                       <span class="btn btn-none fileinput-button"><i class="fas fa-plus"></i>                          
                          <input id="upimagem" type="file" name="imagem" class="btn btn-primary" accept="image/x-png,image/gif,image/jpeg">
                       </span>                       
                     </div>  
                     <!--arquivo de imagem--> 
                </div>
              </div>
                  <fieldset>
                    <legend>Dados de Identificação</legend>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" required class="form-control" name="nome" id="nome" placeholder="Nome do usuário" value="{{$user->name}}">
                            </div>
                        </div>
                    </div>                                                        
                </fieldset>  
                @if(($user->moderador)&&(!$user->inativo))
                <fieldset>                    
                    <legend>Dados de Endereço</legend>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="endereco">Endereço</label>
                                <input type="text" class="endereco form-control" name="endereco" id="endereco" placeholder="informe o endereço" value="{{$user->endereco}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="numero">Número</label>
                                <input type="text" class="numero form-control" name="numero" id="numero" placeholder="nº, apt" value="{{$user->numero}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="bairro">Bairro</label>
                            <input type="text" class="bairro form-control" name="bairro" id="bairro" placeholder="informe o bairro" value="{{$user->bairro}}">
                        </div>
                        <div class="col-md-3">
                            <label for="cidade">Cidade</label>
                            <input type="text" class="cidade form-control" name="cidade" id="cidade" placeholder="informe a cidade" value="{{$user->cidade}}">
                        </div>
                          <div class="col-md-3">
                            <div class="form-group">                                                
                            <label id="pesquisacep" for="edit_cep" style="color: blue;">CEP 
                            <img id="imgpesquisacep" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"><img id="imgcorreios" src="{{asset('storage/c1.png')}}" class="rounded-circle" width="20">
                            <small id="editpesquisacepresposta"></small>              
                            </label>          
                            <input type="text" id="edit_cep" class="cep form-control" placeholder="00000000" data-mask="00000000" data-mask-reverse="true" value="{{$user->cep}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="estado">Estado</label>
                            <select name="estado" id="estado" class="estado custom-select form-control">
                                        <option value="AC" {{old('estado',$user->estado ?? '') === 'AC' ? 'selected' : ''}}>AC - Acre</option>
                                        <option value="AL" {{old('estado',$user->estado ?? '') === 'AL' ? 'selected' : ''}}>AL - Alagoas</option>
                                        <option value="AM" {{old('estado',$user->estado ?? '') === 'AM' ? 'selected' : ''}}>AM - Amazonas</option>
                                        <option value="AP" {{old('estado',$user->estado ?? '') === 'AP' ? 'selected' : ''}}>AP - Amapá</option>
                                        <option value="BA" {{old('estado',$user->estado ?? '') === 'BA' ? 'selected' : ''}}>BA - Bahia</option>
                                        <option value="CE" {{old('estado',$user->estado ?? '') === 'CE' ? 'selected' : ''}}>CE - Ceará</option>
                                        <option value="DF" {{old('estado',$user->estado ?? '') === 'DF' ? 'selected' : ''}}>DF - Distrito Federal</option>
                                        <option value="ES" {{old('estado',$user->estado ?? '') === 'ES' ? 'selected' : ''}}>ES - Espírito Santo</option>
                                        <option value="GO" {{old('estado',$user->estado ?? '') === 'GO' ? 'selected' : ''}}>GO - Goiás</option>
                                        <option value="MA" {{old('estado',$user->estado ?? '') === 'MA' ? 'selected' : ''}}>MA - Maranhão</option>
                                        <option value="MG" {{old('estado',$user->estado ?? '') === 'MG' ? 'selected' : ''}}>MG - Minas Gerais</option>
                                        <option value="MS" {{old('estado',$user->estado ?? '') === 'MS' ? 'selected' : ''}}>MS - Mato Grosso do Sul</option>
                                        <option value="MT" {{old('estado',$user->estado ?? '') === 'MT' ? 'selected' : ''}}>MT - Mato Grosso</option>
                                        <option value="PA" {{old('estado',$user->estado ?? '') === 'PA' ? 'selected' : ''}}>PA - Pará</option>
                                        <option value="PB" {{old('estado',$user->estado ?? '') === 'PB' ? 'selected' : ''}}>PB - Paraíba</option>
                                        <option value="PE" {{old('estado',$user->estado ?? '') === 'PE' ? 'selected' : ''}}>PE - Pernambuco</option>
                                        <option value="PI" {{old('estado',$user->estado ?? '') === 'PI' ? 'selected' : ''}}>PI - Piauí</option>
                                        <option value="PR" {{old('estado',$user->estado ?? '') === 'PR' ? 'selected' : ''}}>PR - Paraná</option>
                                        <option value="RJ" {{old('estado',$user->estado ?? '') === 'RJ' ? 'selected' : ''}}>RJ - Rio de Janeiro</option>
                                        <option value="RN" {{old('estado',$user->estado ?? '') === 'RN' ? 'selected' : ''}}>RN - Rio Grande do Norte</option>
                                        <option value="RO" {{old('estado',$user->estado ?? '') === 'RO' ? 'selected' : ''}}>RO - Rondônia</option>
                                        <option value="RR" {{old('estado',$user->estado ?? '') === 'RR' ? 'selected' : ''}}>RR - Roraima</option>
                                        <option value="RS" {{old('estado',$user->estado ?? '') === 'RS' ? 'selected' : ''}}>RS - Rio Grande do Sul</option>
                                        <option value="SC" {{old('estado',$user->estado ?? '') === 'SC' ? 'selected' : ''}}>SC - Santa Catarina</option>
                                        <option value="SE" {{old('estado',$user->estado ?? '') === 'SE' ? 'selected' : ''}}>SE - Sergipe</option>
                                        <option value="SP" {{old('estado',$user->estado ?? '') === 'SP' ? 'selected' : ''}}>SP - São Paulo</option>
                                        <option value="TO" {{old('estado',$user->estado ?? '') === 'TO' ? 'selected' : ''}}>TO - Tocantins</option>
                            </select>
                        </div>
                    </div>
                </fieldset>
                @endif
                <fieldset>
                    <legend>Dados de Controle</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">e-Mail</label>
                                <input type="text" class="email form-control" name="email" id="email" placeholder="e-Mail do usuário" value="{{$user->email}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="password">Senha</label>
                                <input type="password" class="password form-control" name="password" id="password">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input type="text" class="cpf form-control" name="cpf" id="cpf" placeholder="000.000.000-00" data-mask="000.000.000-00" data-mask-reverse="true" value="{{$user->cpf}}">
                            </div>
                        </div>                    
                    </div>
                    
                    @if(($user->moderador)&&(!$user->inativo))
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="link_instagram">URL Instagram</label>
                                <input type="text" class="link_instagram form-control" name="link_instagram" id="link_instagram" placeholder="https://..instagram" value="{{$user->link_instagram}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="link_facebook">URL Facebook</label>
                                <input type="text" class="link_facebook form-control" name="link_facebook" id="link_facebook" placeholder="https://..facebook" value="{{$user->link_facebook}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="link_site">URL Site</label>
                                <input type="text" class="link_site form-control" name="link_site" id="link_site" placeholder="https://..site" value="{{$user->link_site}}">
                            </div>
                        </div>                 
                    </div>
                    @endif                    
                </fieldset>               
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="modal-footer">
                            <button type="button" class="cancelar_btn btn btn-default">Cancelar</button>
                            <button class="salvar_btn btn btn-primary" type="button"><img id="imgedit" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>    

</div>
<!-- Rodapé-->
        <footer class="border-top">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">                        
                        <div class="small text-center text-muted fst-italic">Copyright &copy; Laravel & Ajax – por Delcione Lopes da Silva</div>
                    </div>
                </div>
            </div>
        </footer>      
@endsection

@section('scripts')
<script type="text/javascript">

$(document).ready(function(){

    $(document).on('click','.salvar_btn',function(e){
        e.preventDefault();
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var loading = $('#imgedit');
            loading.show();

        var id = $('#edit_user_id').val();
        
        var data = new FormData();        
            
            data.append('name',$('#nome').val());            
            data.append('imagem',$('#upimagem')[0].files[0]);            
            data.append('email',$('#email').val());
            data.append('password',$('#password').val());
            data.append('moderador',$('#edit_moderador').val());
            data.append('inativo',$('#edit_inativo').val());
            data.append('cpf',$('#cpf').val());
            data.append('endereco',$('#endereco').val());
            data.append('numero',$('#numero').val());
            data.append('bairro',$('#bairro').val());
            data.append('cidade',$('#cidade').val());
            data.append('cep',$('#edit_cep').val());
            data.append('estado',$('#estado').val());
            data.append('link_instagram',$('#link_instagram').val());
            data.append('link_facebook',$('#link_facebook').val());
            data.append('link_site',$('#link_site').val());           
            data.append('_enctype','multipart/form-data');
            data.append('_token',CSRF_TOKEN);
            data.append('_method','PUT');              

        $.ajax({
            url: '/perfil/'+id,
            type: 'POST',
            dataType: 'json',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            async:true,
            success: function(response){
                if(response.status==400){
                      $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');
                        $('#saveform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveform_errList').append('<li>'+err_values+'</li>');
                        });
                        loading.hide();
                } else{
                    loading.hide();
                    $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');
                    loading.hide();
                    location.replace('/home');
                }  
            }  
        });

    });

    //upload da foto temporária
         $(document).on('change','#upimagem',function(){  
          
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var fd = new FormData();
            var files = $(this)[0].files;                      

            if(files.length > 0){
            // Append data 
            fd.append('imagem',$(this)[0].files[0]);      
            fd.append('_token',CSRF_TOKEN);
            fd.append('_enctype','multipart/form-data');
            fd.append('_method','put');      
            
        $.ajax({                      
                type: 'POST',                             
                url:'/fototemp-upload',                
                dataType: 'json',            
                data: fd,
                cache: false,
                processData: false,
                contentType: false,                                                                                     
                success: function(response){                              
                    if(response.status==400){
                        $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');
                        $('#saveform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveform_errList').append('<li>'+err_values+'</li>');
                        });
                }else{                                                     
                        var arq = response.filepath; 
                            arq = arq.toString();                  ;
                        var linkimagem = '{{asset('')}}'+arq;                        
                        var imagemnova = '<img src="'+linkimagem+'" class="imgfoto rounded-circle" width="100" >';
                        $(".imgfoto").replaceWith(imagemnova);
                    }   
                }                                  
            });
        }
        });   
    //fim upload da foto temporária
    ///excluir imagem temporária pelo cancelamento
    $(document).on('click','.cancelar_btn',function(e){
        e.preventDefault();
        var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var files = $('#upimagem')[0].files;                      

        if(files.length > 0){
        var data = new FormData();
            data.append('imagem',$('#upimagem')[0].files[0]);
            data.append('_token',CSRF_TOKEN);
            data.append('_enctype','multipart/form-data');
            data.append('_method','delete');   
             $.ajax({                      
                type: 'POST',                             
                url:'/delete-fototemp',                
                dataType: 'json',            
                data: data,
                cache: false,
                processData: false,
                contentType: false,                                                                                     
                success: function(response){                              
                    if(response.status==200){
                    $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');
                    location.replace('/home');
                } 
                }                                  
            });

        }else{
            location.replace('/home');
        }

    });
    //fim excluir imagem temporária pelo cancelamento

    ///busca cep
     $(document).on('click','#pesquisacep',function(e){
        e.preventDefault();
        var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var loading = $('#imgpesquisacep');
                var cep = $("#edit_cep").val().replace(/[^0-9]/g,'');
                          $("#imgcorreios").replaceWith('<img id="imgcorreios">')
                loading.show();
                if(cep !== "" && cep.length == 8){
                 $.ajax({
                    url:'/cep/' + cep,
                    type:'GET',
                    dataType:'json',
                    success: function (response) {
                            if(response.status==200){
                                if(response.localizacao.erro){
                                    $('#editpesquisacepresposta').replaceWith('<small id="editpesquisacepresposta" style="color:red;">CEP não localizado!</small>');
                                     loading.hide();
                                     var link = '{{asset('')}}storage/c1.png';
                                     $('#imgcorreios').replaceWith('<img id="imgcorreios" src="'+link+'" class="rounded-circle" width="20">');
                                }else{
                                $(".endereco").val(response.localizacao.logradouro);                                
                                $(".bairro").val(response.localizacao.bairro);
                                $(".cidade").val(response.localizacao.localidade);
                                $(".estado").val(response.localizacao.uf);                                
                                loading.hide();
                                var link = '{{asset('')}}storage/c1.png';
                                $('#imgcorreios').replaceWith('<img id="imgcorreios" src="'+link+'" class="rounded-circle" width="20">');
                                $('#editpesquisacepresposta').replaceWith('<small id="editpesquisacepresposta"></small>');
                                }
                            }
                         }
                });
                }else{
                    $('#editpesquisacepresposta').replaceWith('<small id="editpesquisacepresposta" style="color:red;">CEP deve conter 8 digitos</small>');
                    loading.hide();
                    var link = '{{asset('')}}storage/c1.png';
                    $('#imgcorreios').replaceWith('<img id="imgcorreios" src="'+link+'" class="rounded-circle" width="20">');
                }

     });
    //fim busca cep

});

</script>
@endsection
