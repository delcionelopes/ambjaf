@extends('adminlte::page')

@section('title', 'Criação de usuários')

@section('content')

<form role="form" enctype="multipart/form-data" method="POST">
    @csrf
    @method('PUT')
    <ul id="saveform_errList"></ul> 
    <div class="container-fluid py-5">
        <div class="card">
            <div class="card-body">
              <div class="card p-3" style="background-image: url('/assets/img/banner-docs.jpg')">
                <div class="d-flex align-items-center">
                    <!--arquivo de imagem-->
                    <div class="form-group mb-3">                                                
                       <div class="image">                            
                            <img src="{{asset('storage/user.png')}}" class="imgfoto rounded-circle" width="100" >
                        </div>
                       <label for="upimagem">Foto</label>                        
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
                                <input type="text" required class="form-control" name="nome" id="nome" placeholder="Nome do usuário">
                            </div>
                        </div>
                    </div>                                              
                </fieldset>

                <fieldset>
                    <legend>Dados de Endereço</legend>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="endereco">Endereço</label>
                                <input type="text" class="endereco form-control" name="endereco" id="endereco" placeholder="informe o endereço">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="numero">Número</label>
                                <input type="text" class="numero form-control" name="numero" id="numero" placeholder="nº, apt">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="bairro">Bairro</label>
                            <input type="text" class="bairro form-control" name="bairro" id="bairro" placeholder="informe o bairro">
                        </div>
                        <div class="col-md-3">
                            <label for="cidade">Cidade</label>
                            <input type="text" class="cidade form-control" name="cidade" id="cidade" placeholder="informe a cidade">
                        </div>
                        <div class="col-md-3">
                         <div class="form-group">                        
                            <label id="addpesquisacep" for="add_cep" style="color: blue;">CEP 
                            <img id="addimgpesquisacep" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"><img id="addimgcorreios" src="{{asset('storage/c1.png')}}" class="rounded-circle" width="20">
                            <small id="addpesquisacepresposta"></small>              
                            </label>          
                            <input type="text" id="add_cep" class="cep form-control" placeholder="00000000" data-mask="00000000" data-mask-reverse="true">                        
                        </div>
                        </div>
                        <div class="col-md-2">
                            <label for="estado">Estado</label>
                            <select name="estado" id="estado" class="estado custom-select">
                                        <option value="AC">AC - Acre</option>
                                        <option value="AL">AL - Alagoas</option>
                                        <option value="AM">AM - Amazonas</option>
                                        <option value="AP">AP - Amapá</option>
                                        <option value="BA">BA - Bahia</option>
                                        <option value="CE">CE - Ceará</option>
                                        <option value="DF">DF - Distrito Federal</option>
                                        <option value="ES">ES - Espírito Santo</option>
                                        <option value="GO">GO - Goiás</option>
                                        <option value="MA">MA - Maranhão</option>
                                        <option value="MG">MG - Minas Gerais</option>
                                        <option value="MS">MS - Mato Grosso do Sul</option>
                                        <option value="MT">MT - Mato Grosso</option>
                                        <option value="PA">PA - Pará</option>
                                        <option value="PB">PB - Paraíba</option>
                                        <option value="PE">PE - Pernambuco</option>
                                        <option value="PI">PI - Piauí</option>
                                        <option value="PR">PR - Paraná</option>
                                        <option value="RJ">RJ - Rio de Janeiro</option>
                                        <option value="RN">RN - Rio Grande do Norte</option>
                                        <option value="RO">RO - Rondônia</option>
                                        <option value="RR">RR - Roraima</option>
                                        <option value="RS">RS - Rio Grande do Sul</option>
                                        <option value="SC">SC - Santa Catarina</option>
                                        <option value="SE">SE - Sergipe</option>
                                        <option value="SP">SP - São Paulo</option>
                                        <option value="TO">TO - Tocantins</option>
                            </select>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Dados de Controle</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">e-Mail</label>
                                <input type="text" class="email form-control" name="email" id="email" placeholder="e-Mail do usuário">
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
                                <input type="text" class="form-control" name="cpf" id="cpf" placeholder="000.000.000-00" data-mask="000.000.000-00" data-mask-reverse="true">
                            </div>
                        </div>
                    </div>                    
                    <div class="row">       
                         <div class="col-md-4">
                            <div class="form-group">
                                <label for="idperfil">Perfil</label>
                                <select name="idperfil" id="idperfil" class="idperfil custom-select">
                                    @foreach ($perfis as $perfil)
                                    <option value="{{$perfil->id}}">{{$perfil->nome}}</option>
                                    @endforeach                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="">Privilégio</label>
                            <div class="form-group">
                                <label for="admin">
                                <input type="checkbox" class="admin checkbox" name="admin" id="admin"> Admin</label>
                            </div>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="link_instagram">URL Instagram</label>
                                <input type="text" class="link_instagram form-control" name="link_instagram" id="link_instagram" placeholder="https://..instagram">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="link_facebook">URL Facebook</label>
                                <input type="text" class="link_facebook form-control" name="link_facebook" id="link_facebook" placeholder="https://..facebook">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="link_site">URL Site</label>
                                <input type="text" class="link_site form-control" name="link_site" id="link_site" placeholder="https://..site">
                            </div>
                        </div>                 
                    </div>                    
                </fieldset>               
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="modal-footer">
                            <button type="button" class="cancelar_btn btn btn-default">Cancelar</button>
                            <button class="salvar_btn btn btn-primary" type="button"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@stop

@section('css')

<link href="{{asset('css/styles.css')}}" rel="stylesheet"/>
    
@stop

@section('js')

<script type="text/javascript">

$(document).ready(function(){

    $(document).on('click','.salvar_btn',function(e){
        e.preventDefault();
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
        var loading = $('#imgadd');
            loading.show();
        
        var data = new FormData();        
            
            data.append('name',$('#nome').val());
            data.append('perfil_id',$('#idperfil').val());
            data.append('imagem',$('#upimagem')[0].files[0]);            
            data.append('inativo', 'false');
            data.append('admin',$('#admin').is(":checked")?'1':'0');
            data.append('email',$('#email').val());
            data.append('password',$('#password').val());
            data.append('cpf',$('#cpf').val());
            data.append('endereco',$('#endereco').val());
            data.append('numero',$('#numero').val());
            data.append('bairro',$('#bairro').val());
            data.append('cidade',$('#cidade').val());
            data.append('cep',$('#add_cep').val());
            data.append('estado',$('#estado').val());
            data.append('link_instagram',$('#link_instagram').val());
            data.append('link_facebook',$('#link_facebook').val());
            data.append('link_site',$('#link_site').val());           
            data.append('_enctype','multipart/form-data');
            data.append('_token',CSRF_TOKEN);
            data.append('_method','put');              

        $.ajax({
            url: '/admin/user/store',
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
                     location.replace('/admin/user/index');
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
            
            fd.append('imagem',$(this)[0].files[0]);      
            fd.append('_token',CSRF_TOKEN);
            fd.append('_enctype','multipart/form-data');
            fd.append('_method','put');      
            
        $.ajax({                      
                type: 'POST',                             
                url:'/admin/user/fototemp-upload',                
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
                        var linkimagem = "{{asset('')}}"+arq;                        
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
        var data = new FormData();
        var files = $('#upimagem')[0].files;                      

        if(files.length > 0){
        
            data.append('imagem',$('#upimagem')[0].files[0]);
            data.append('_token',CSRF_TOKEN);
            data.append('_enctype','multipart/form-data');
            data.append('_method','delete');   
             $.ajax({                      
                type: 'POST',                             
                url:'/admin/user/delete-fototemp',                
                dataType: 'json',            
                data: data,
                cache: false,
                processData: false,
                contentType: false,                                                                                     
                success: function(response){                              
                    if(response.status==200){
                    $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');                         
                    location.replace('/admin/user/index');
                } 
                }                                  
            });

        }else{
            location.replace('/admin/user/index');
        }

    });
    //fim excluir imagem temporária pelo cancelamento

    //busca cep
   $(document).on('click','#addpesquisacep',function(e){
        e.preventDefault();
        var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var loading = $('#addimgpesquisacep');
                var cep = $("#add_cep").val().replace(/[^0-9]/g,'');
                          $("#addimgcorreios").replaceWith('<img id="addimgcorreios">')
                loading.show();
                if(cep !== "" && cep.length == 8){
                 $.ajax({
                    url:'/cep/' + cep,
                    type:'GET',
                    dataType:'json',
                    success: function (response) {
                            if(response.status==200){
                                if(response.localizacao.erro){
                                    $('#addpesquisacepresposta').replaceWith('<small id="addpesquisacepresposta" style="color:red;">CEP não localizado!</small>');
                                     loading.hide();
                                     var link = "{{asset('')}}storage/c1.png";
                                     $('#addimgcorreios').replaceWith('<img id="addimgcorreios" src="'+link+'" class="rounded-circle" width="20">');
                                }else{
                                $(".endereco").val(response.localizacao.logradouro);                                
                                $(".bairro").val(response.localizacao.bairro);
                                $(".cidade").val(response.localizacao.localidade);
                                $(".estado").val(response.localizacao.uf);                                
                                loading.hide();
                                var link = "{{asset('')}}storage/c1.png";
                                $('#addimgcorreios').replaceWith('<img id="addimgcorreios" src="'+link+'" class="rounded-circle" width="20">');
                                $('#addpesquisacepresposta').replaceWith('<small id="addpesquisacepresposta"></small>');
                                }
                            }
                         }
                });
                }else{
                    $('#addpesquisacepresposta').replaceWith('<small id="addpesquisacepresposta" style="color:red;">CEP deve conter 8 digitos</small>');
                    loading.hide();
                    var link = "{{asset('')}}storage/c1.png";
                    $('#addimgcorreios').replaceWith('<img id="addimgcorreios" src="'+link+'" class="rounded-circle" width="20">');
                }

     });
    ///fim busca cep

});

</script>

@stop