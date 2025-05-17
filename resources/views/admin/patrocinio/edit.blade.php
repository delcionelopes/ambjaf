@extends('adminlte::page')

@section('title', 'Edição de Patrocinadores')

@section('content')

<form role="form" enctype="multipart/form-data" method="POST">
    @csrf
    @method('PUT')
    <ul id="saveform_errList"></ul>
    <input type="hidden" id="edit_patrocinio_id" value="{{$patrocinio->id}}">
    <div class="container-fluid py-5">
        <div class="card">
            <div class="card-body">
              <div class="card p-3" style="background-image: url('/assets/img/banner-docs.jpg')">
                <div class="d-flex align-items-center">
                    <!--arquivo de imagem-->
                    <div class="form-group mb-3">                                                
                       <div class="image">           
                        @if($patrocinio->logo)                 
                            <img src="{{asset('storage/'.$patrocinio->logo)}}" class="imgico rounded-circle" width="100" >
                        @else
                            <img src="{{asset('storage/user.png')}}" class="imgico rounded-circle" width="100" >
                        @endif    
                        </div>
                       <label for="">Logo</label>                        
                       <span class="btn btn-none fileinput-button"><i class="fas fa-plus"></i>                          
                          <input id="upimagem" type="file" name="imagem" class="btn btn-{{$color}}" accept="image/x-png,image/gif,image/jpeg">
                       </span>                       
                     </div>  
                     <!--arquivo de imagem--> 
                </div>
              </div>
                  <fieldset>
                    <legend>Dados do Patrocinador</legend>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" class="nome form-control" name="nome" id="nome" placeholder="Nome do patrocinador" value="{{$patrocinio->nome}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                              <div class="form-group">
                                <label for="sigla">Sigla</label>
                                <input type="text" class="sigla form-control" name="sigla" id="sigla" placeholder="Sigla do patrocinador" value="{{$patrocinio->sigla}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                              <div class="form-group">
                                <label for="cnpj">CNPJ</label>
                                <input type="text" class="cnpj form-control" name="cnpj" id="cnpj" placeholder="CNPJ do patrocinador" value="{{$patrocinio->cnpj}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                              <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input type="text" class="cpf form-control" name="cpf" id="cpf" placeholder="CPF do patrocinador" value="{{$patrocinio->cpf}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-2">
                            <label for="">Status</label>
                            <div class="form-group">
                                <label for="inativo">
                                @if($patrocinio->inativo)
                                <input type="checkbox" class="inativo checkbox" name="inativo" id="inativo" checked> Inativo
                                @else
                                <input type="checkbox" class="inativo checkbox" name="inativo" id="inativo"> Inativo
                                @endif
                                </label>
                            </div>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-4">
                              <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="email form-control" name="email" id="email" placeholder="email do patrocinador" value="{{$patrocinio->email}}">
                            </div>
                        </div>                        
                    </div>                    
                    <div class="row">
                        <div class="col-md-4">
                              <div class="form-group">
                                <label for="link_site">Link do Site</label>
                                <input type="text" class="link_site form-control" name="link_site" id="link_site" placeholder="https://..site" value="{{$patrocinio->link_site}}">
                            </div>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                              <div class="form-group">
                                <label for="contato">Contato</label>
                                <input type="text" class="contato form-control" name="contato" id="contato" placeholder="Contato do patrocinador" value="{{$patrocinio->contato}}">
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
                                <input type="text" class="endereco form-control" name="endereco" id="endereco" placeholder="informe o endereço" value="{{$patrocinio->endereco}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="numero">Número</label>
                                <input type="text" class="numero form-control" name="numero" id="numero" placeholder="nº, apt" value="{{$patrocinio->numero}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="bairro">Bairro</label>
                            <input type="text" class="bairro form-control" name="bairro" id="bairro" placeholder="informe o bairro" value="{{$patrocinio->bairro}}">
                        </div>
                        <div class="col-md-3">
                            <label for="cidade">Cidade</label>
                            <input type="text" class="cidade form-control" name="cidade" id="cidade" placeholder="informe a cidade" value="{{$patrocinio->cidade}}">
                        </div>
                        <div class="col-md-3">
                         <div class="form-group">                        
                            <label id="editpesquisacep" for="edit_cep" style="color: blue;">CEP 
                            <img id="editimgpesquisacep" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"><img id="editimgcorreios" src="{{asset('storage/c1.png')}}" class="rounded-circle" width="20">
                            <small id="editpesquisacepresposta"></small>              
                            </label>          
                            <input type="text" id="edit_cep" class="cep form-control" placeholder="00000000" data-mask="00000000" data-mask-reverse="true" value="{{$patrocinio->cep}}">
                        </div>
                        </div>
                        <div class="col-md-2">
                            <label for="estado">Estado</label>
                            <select name="estado" id="estado" class="estado custom-select">
                                        <option value="AC" {{old('estado',$patrocinio->estado ?? '') === 'AC' ? 'selected' : ''}}>AC - Acre</option>
                                        <option value="AL" {{old('estado',$patrocinio->estado ?? '') === 'AL' ? 'selected' : ''}}>AL - Alagoas</option>
                                        <option value="AM" {{old('estado',$patrocinio->estado ?? '') === 'AM' ? 'selected' : ''}}>AM - Amazonas</option>
                                        <option value="AP" {{old('estado',$patrocinio->estado ?? '') === 'AP' ? 'selected' : ''}}>AP - Amapá</option>
                                        <option value="BA" {{old('estado',$patrocinio->estado ?? '') === 'BA' ? 'selected' : ''}}>BA - Bahia</option>
                                        <option value="CE" {{old('estado',$patrocinio->estado ?? '') === 'CE' ? 'selected' : ''}}>CE - Ceará</option>
                                        <option value="DF" {{old('estado',$patrocinio->estado ?? '') === 'DF' ? 'selected' : ''}}>DF - Distrito Federal</option>
                                        <option value="ES" {{old('estado',$patrocinio->estado ?? '') === 'ES' ? 'selected' : ''}}>ES - Espírito Santo</option>
                                        <option value="GO" {{old('estado',$patrocinio->estado ?? '') === 'GO' ? 'selected' : ''}}>GO - Goiás</option>
                                        <option value="MA" {{old('estado',$patrocinio->estado ?? '') === 'MA' ? 'selected' : ''}}>MA - Maranhão</option>
                                        <option value="MG" {{old('estado',$patrocinio->estado ?? '') === 'MG' ? 'selected' : ''}}>MG - Minas Gerais</option>
                                        <option value="MS" {{old('estado',$patrocinio->estado ?? '') === 'MS' ? 'selected' : ''}}>MS - Mato Grosso do Sul</option>
                                        <option value="MT" {{old('estado',$patrocinio->estado ?? '') === 'MT' ? 'selected' : ''}}>MT - Mato Grosso</option>
                                        <option value="PA" {{old('estado',$patrocinio->estado ?? '') === 'PA' ? 'selected' : ''}}>PA - Pará</option>
                                        <option value="PB" {{old('estado',$patrocinio->estado ?? '') === 'PB' ? 'selected' : ''}}>PB - Paraíba</option>
                                        <option value="PE" {{old('estado',$patrocinio->estado ?? '') === 'PE' ? 'selected' : ''}}>PE - Pernambuco</option>
                                        <option value="PI" {{old('estado',$patrocinio->estado ?? '') === 'PI' ? 'selected' : ''}}>PI - Piauí</option>
                                        <option value="PR" {{old('estado',$patrocinio->estado ?? '') === 'PR' ? 'selected' : ''}}>PR - Paraná</option>
                                        <option value="RJ" {{old('estado',$patrocinio->estado ?? '') === 'RJ' ? 'selected' : ''}}>RJ - Rio de Janeiro</option>
                                        <option value="RN" {{old('estado',$patrocinio->estado ?? '') === 'RN' ? 'selected' : ''}}>RN - Rio Grande do Norte</option>
                                        <option value="RO" {{old('estado',$patrocinio->estado ?? '') === 'RO' ? 'selected' : ''}}>RO - Rondônia</option>
                                        <option value="RR" {{old('estado',$patrocinio->estado ?? '') === 'RR' ? 'selected' : ''}}>RR - Roraima</option>
                                        <option value="RS" {{old('estado',$patrocinio->estado ?? '') === 'RS' ? 'selected' : ''}}>RS - Rio Grande do Sul</option>
                                        <option value="SC" {{old('estado',$patrocinio->estado ?? '') === 'SC' ? 'selected' : ''}}>SC - Santa Catarina</option>
                                        <option value="SE" {{old('estado',$patrocinio->estado ?? '') === 'SE' ? 'selected' : ''}}>SE - Sergipe</option>
                                        <option value="SP" {{old('estado',$patrocinio->estado ?? '') === 'SP' ? 'selected' : ''}}>SP - São Paulo</option>
                                        <option value="TO" {{old('estado',$patrocinio->estado ?? '') === 'TO' ? 'selected' : ''}}>TO - Tocantins</option>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <div class="row">
                    <div class="col-md-12">
                        <div class="modal-footer">
                            <button type="button" data-color="{{$color}}" class="cancelar_btn btn btn-default">Cancelar</button>
                            <button class="salvar_btn btn btn-{{$color}}" data-color="{{$color}}" type="button"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
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
        
        var id = $('#edit_patrocinio_id').val();
        var color = $(this).data("color");

        var data = new FormData();        
            
            data.append('nome',$('#nome').val());
            data.append('sigla',$('#sigla').val());
            data.append('inativo', $('#inativo').is(":checked")?'1':'0');
            data.append('email',$('#email').val());
            data.append('imagem',$('#upimagem')[0].files[0]);         
            data.append('link_site',$('#link_site').val());
            data.append('contato',$('#contato').val());
            data.append('cnpj',$('#cnpj').val());
            data.append('cpf',$('#cpf').val());
            data.append('endereco',$('#endereco').val());
            data.append('numero',$('#numero').val());
            data.append('bairro',$('#bairro').val());
            data.append('cidade',$('#cidade').val());
            data.append('cep',$('#edit_cep').val());
            data.append('estado',$('#estado').val());
            data.append('_enctype','multipart/form-data');
            data.append('_token',CSRF_TOKEN);
            data.append('_method','PUT');              

        $.ajax({
            url: '/admin/patrocinios/update/'+id,
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
                } else{
                    $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');  
                    loading.hide();
                     location.replace('/admin/patrocinios/index/'+color);
                }  
            }  
        });

    });

    //upload da imagem temporária
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
                url:'/admin/patrocinios/imagemtemp-upload',                
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
                        var imagemnova = '<img src="'+linkimagem+'" class="imgico rounded-circle" width="100" >';
                        $(".imgico").replaceWith(imagemnova);
                    }   
                }                                  
            });
        }
        });   
    //fim upload da imagem temporária
    ///excluir imagem temporária pelo cancelamento
    $(document).on('click','.cancelar_btn',function(e){
        e.preventDefault();
        var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var files = $('#upimagem')[0].files;
        var color = $(this).data("color");

        if(files.length > 0){
        var data = new FormData();
            data.append('imagem',$('#upimagem')[0].files[0]);
            data.append('_token',CSRF_TOKEN);
            data.append('_enctype','multipart/form-data');
            data.append('_method','delete');   
             $.ajax({                      
                type: 'POST',                             
                url:'/admin/patrocinios/delete-imgtemp',                
                dataType: 'json',            
                data: data,
                cache: false,
                processData: false,
                contentType: false,                                                                                     
                success: function(response){                              
                    if(response.status==200){
                    $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');
                    location.replace('/admin/patrocinios/index/'+color);
                } 
                }                                  
            });

        }else{
            location.replace('/admin/patrocinios/index/'+color);
        }

    });
    //fim excluir imagem temporária pelo cancelamento

    ///busca cep
    $(document).on('click','#editpesquisacep',function(e){
        e.preventDefault();
        var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var loading = $('#editimgpesquisacep');
                var cep = $("#edit_cep").val().replace(/[^0-9]/g,'');
                          $("#editimgcorreios").replaceWith('<img id="editimgcorreios">')
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
                                     var link = "{{asset('')}}storage/c1.png";
                                     $('#editimgcorreios').replaceWith('<img id="editimgcorreios" src="'+link+'" class="rounded-circle" width="20">');
                                }else{
                                $(".endereco").val(response.localizacao.logradouro);                                
                                $(".bairro").val(response.localizacao.bairro);
                                $(".cidade").val(response.localizacao.localidade);
                                $(".estado").val(response.localizacao.uf);
                                $(".cep").val(cep);
                                loading.hide();
                                var link = "{{asset('')}}storage/c1.png";
                                $('#editimgcorreios').replaceWith('<img id="editimgcorreios" src="'+link+'" class="rounded-circle" width="20">');
                                $('#editpesquisacepresposta').replaceWith('<small id="editpesquisacepresposta"></small>');
                                }
                            }
                         }
                });
                }else{
                    $('#editpesquisacepresposta').replaceWith('<small id="editpesquisacepresposta" style="color:red;">CEP deve conter 8 digitos</small>');
                    loading.hide();
                    var link = "{{asset('')}}storage/c1.png";
                    $('#editimgcorreios').replaceWith('<img id="editimgcorreios" src="'+link+'" class="rounded-circle" width="20">');
                }

     });
    //fim busca cep

});

</script>

@stop