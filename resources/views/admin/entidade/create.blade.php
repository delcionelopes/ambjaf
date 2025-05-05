@extends('adminlte::page')

@section('title', 'Cadastro de Entidade')

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
                            <img src="{{asset('storage/user.png')}}" class="imgico rounded-circle" width="100" >
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
                    <legend>Dados da Entidade</legend>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" required class="form-control" name="nome" id="nome" placeholder="Nome da entidade">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                              <div class="form-group">
                                <label for="sigla">Sigla</label>
                                <input type="text" required class="form-control" name="sigla" id="sigla" placeholder="Sigla da entidade">
                            </div>
                        </div>
                        <div class="col-md-4">
                              <div class="form-group">
                                <label for="cnpj">CNPJ</label>
                                <input type="text" required class="form-control" name="cnpj" id="cnpj" placeholder="CNPJ da entidade">
                            </div>
                        </div>                        
                    </div>
                    <div class="row">
                         <div class="col-md-4">
                              <div class="form-group">
                                <label for="fundacao">Fundação</label>
                                <input type="text" required class="form-control" name="fundacao" id="fundacao" placeholder="DD/MM/AAAA" data-mask="00/00/0000" data-mask-reverse="true">
                            </div>
                        </div>
                        <div class="col-md-8">
                              <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="text" required class="form-control" name="email" id="email" placeholder="e-mail da entidade">
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

                <div class="card">
                     <div class="card-body"> 
                            <fieldset>
                                <legend>Patrocínios</legend>
                                <div class="form-check">                                                                        
                                    @foreach ($patrocinios as $patrocinio)
                                    <label class="form-check-label" for="check{{$patrocinio->id}}">
                                        <input type="checkbox" id="check{{$patrocinio->id}}" name="patrocinios[]" value="{{$patrocinio->id}}" class="form-check-input"> {{$patrocinio->sigla}}
                                    </label><br>
                                    @endforeach                                    
                                </div>
                            </fieldset>   
                     </div>
                </div>

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
        var files = $('#upimagem')[0].files;
        var color = $(this).data("color");
        
        var patrocinios = new Array();
                $("input[name='patrocinios[]']:checked").each(function(){
                    patrocinios.push($(this).val());
                });

        var data = new FormData();        
            
            data.append('nome',$('#nome').val());
            data.append('sigla',$('#sigla').val());
            data.append('email',$('#email').val());
            data.append('fundacao',formatDate($('#fundacao').val()));
            data.append('imagem',$('#upimagem')[0].files[0]);
            data.append('cnpj',$('#cnpj').val());
            data.append('endereco',$('#endereco').val());
            data.append('numero',$('#numero').val());
            data.append('bairro',$('#bairro').val());
            data.append('cidade',$('#cidade').val());
            data.append('cep',$('#add_cep').val());
            data.append('estado',$('#estado').val());
            data.append('patrocinios',JSON.stringify(patrocinios)); //array
            data.append('_enctype','multipart/form-data');
            data.append('_token',CSRF_TOKEN);
            data.append('_method','PUT');              

        $.ajax({
            url: '/admin/entidades/store',
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
                    $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');  
                    loading.hide();
                     location.replace('/admin/entidades/index/'+color);
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
                url:'/admin/entidades/imagemtemp-upload',                
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
                url:'/admin/entidades/delete-imgtemp',                
                dataType: 'json',            
                data: data,
                cache: false,
                processData: false,
                contentType: false,                                                                                     
                success: function(response){                              
                    if(response.status==200){
                    $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');
                    location.replace('/admin/entidades/index/'+color);
                } 
                }                                  
            });

        }else{
            location.replace('/admin/entidades/index/'+color);
        }

    });
    //fim excluir imagem temporária pelo cancelamento

    ///busca cep
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
    //fim busca cep

    //formatação str para date
       function formatDate(data, formato) {
        if (formato == 'pt-br') {
            return (data.substr(0, 10).split('-').reverse().join('/'));
        } else {
            return (data.substr(0, 10).split('/').reverse().join('-'));
        }
        }
    //fim formatDate

});

</script>

@stop