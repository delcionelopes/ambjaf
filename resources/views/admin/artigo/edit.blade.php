@extends('adminlte::page')

@section('title', 'Edição de artigos')

@section('content')

<form role="form" enctype="multipart/form-data" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" id="edit_artigo_id" value="{{$artigo->id}}">
    <ul id="saveform_errList"></ul> 
    <header class="masthead" style="background-image: url('/storage/{{$artigo->imagem}}')">
        <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="post-heading">
                            <h1>{{$artigo->titulo}}</h1>
                            <h2 class="subheading">{{$artigo->descricao}}</h2>
                            <span class="meta">
                                Postado por
                                <a href="#!">{{$artigo->users->name}}</a>
                                @if($artigo->users->avatar)
                                <img src="{{asset('/storage/'.$artigo->users->avatar)}}" class="imgfoto rounded-circle" width="50">                                
                                @else
                                <img src="{{asset('storage/user.png')}}" class="imgfoto rounded-circle" width="100">                                
                                @endif
                                <span class="caret"></span><br>
                                {{ucwords(strftime('%A, %d de %B de %Y', strtotime($artigo->created_at)))}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
    </header>              
    <div class="container-fluid py-5">
        <div class="card">
            <div class="card-body">
                <label for="upimagem">Capa</label>                        
                <span class="btn btn-none fileinput-button"><i class="fas fa-plus"></i>
                <input id="upimagem" type="file" name="imagem" class="btn btn-{{$color}}" accept="image/x-png,image/gif,image/jpeg">
                </span>
            </div>
        </div>        
        <div class="card">
        <div class="card-body">                          
                <fieldset>
                    <legend>Identificação da postagem</legend>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="titulo">Título</label>
                                <input type="text" required class="titulo form-control" name="titulo" id="titulo" placeholder="Informe o título" value="{{$artigo->titulo}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descricao">Descrição</label>
                                <input type="text" required class="descricao form-control" name="descricao" id="descricao" placeholder="Informe a descrição" value="{{$artigo->descricao}}">
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Conteúdo</legend>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Teor da postagem</label>
                                <textarea class="conteudo form-control" name="conteudo" placeholder="informe o conteúdo" cols="30" rows="10">{{$artigo->conteudo}}</textarea>
                            </div>
                        </div>                        
                    </div>
                </fieldset>
                
                <div class="card">
                     <div class="card-body"> 
                            <fieldset>
                                <legend>Temas</legend>
                                <div class="form-check">                                                                        
                                    @foreach ($temas as $tema)
                                    @if($artigo->temas->count())
                                        @foreach($artigo->temas as $temaartigo)
                                        @if(($tema->id) == ($temaartigo->id))
                                        <label class="form-check-label" for="check{{$tema->id}}">
                                            <input type="checkbox" id="check{{$tema->id}}" name="temas[]" value="{{$tema->id}}" class="form-check-input" checked> {{$tema->titulo}}
                                        </label><br>
                                        @break
                                        @elseif ($loop->last)
                                        <label class="form-check-label" for="check{{$tema->id}}">
                                            <input type="checkbox" id="check{{$tema->id}}" name="temas[]" value="{{$tema->id}}" class="form-check-input"> {{$tema->titulo}}
                                        </label><br>
                                        @endif
                                        @endforeach
                                    @else
                                    <label class="form-check-label" for="check{{$tema->id}}">
                                        <input type="checkbox" id="check{{$tema->id}}" name="temas[]" value="{{$tema->id}}" class="form-check-input"> {{$tema->titulo}}
                                    </label><br>
                                    @endif
                                    @endforeach
                                </div>
                            </fieldset>   
                     </div>
                </div>

                <div class="card">
                     <div class="card-body"> 
                            <fieldset>
                                <legend>Patrocínios</legend>
                                <div class="form-check">                                                                        
                                    @foreach ($patrocinios as $patrocinio)
                                    @if($artigo->patrocinios->count())
                                        @foreach($artigo->patrocinios as $patrocinioartigo)
                                        @if(($patrocinio->id) == ($patrocinioartigo->id))
                                        <label class="form-check-label" for="check{{$patrocinio->id}}">
                                            <input type="checkbox" id="check{{$patrocinio->id}}" name="patrocinios[]" value="{{$patrocinio->id}}" class="form-check-input" checked> {{$patrocinio->sigla}}
                                        </label><br>
                                        @break
                                        @elseif ($loop->last)
                                        <label class="form-check-label" for="check{{$patrocinio->id}}">
                                            <input type="checkbox" id="check{{$patrocinio->id}}" name="patrocinios[]" value="{{$patrocinio->id}}" class="form-check-input"> {{$patrocinio->sigla}}
                                        </label><br>
                                        @endif
                                        @endforeach
                                    @else
                                    <label class="form-check-label" for="check{{$patrocinio->id}}">
                                        <input type="checkbox" id="check{{$patrocinio->id}}" name="patrocinios[]" value="{{$patrocinio->id}}" class="form-check-input"> {{$patrocinio->sigla}}
                                    </label><br>
                                    @endif
                                    @endforeach
                                </div>
                            </fieldset>   
                     </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="modal-footer">
                            <button type="button" data-color="{{$color}}" class="cancelar_btn btn btn-default">Cancelar</button>
                            <button class="update_btn btn btn-{{$color}}" data-color="{{$color}}" type="button"><img id="imgedit" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
                        </div>
                    </div>
                </div>

            </div> <!-- card-body -->       
        </div> <!-- card -->
    </div> <!-- card-fluid -->
</form>
@stop

@section('css')

<link href="{{asset('css/styles.css')}}" rel="stylesheet"/>
    
@stop

@section('js')

<script type="text/javascript">

$(document).ready(function(){

    $(document).on('click','.update_btn',function(e){
        e.preventDefault();
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
        var loading = $('#imgedit');
            loading.show();
        var id = $('#edit_artigo_id').val();
        var color = $(this).data("color");

        //Array apenas com os checkboxes marcados
        var temas = new Array();
                $("input[name='temas[]']:checked").each(function(){
                    temas.push($(this).val());
                });        
        
        var patrocinios = new Array();
                $("input[name='patrocinios[]']:checked").each(function(){
                    patrocinios.push($(this).val());
                });        

        var data = new FormData();        
            
            data.append('titulo',$('#titulo').val());
            data.append('descricao',$('#descricao').val());
            data.append('conteudo',$('.conteudo').val());
            data.append('imagem',$('#upimagem')[0].files[0]);
            data.append('temas',JSON.stringify(temas)); //array
            data.append('patrocinios',JSON.stringify(patrocinios)); //array
            data.append('_enctype','multipart/form-data');
            data.append('_token',CSRF_TOKEN);
            data.append('_method','put');              

        $.ajax({
            url: '/admin/artigos/update/'+id,
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
                    location.replace('/admin/artigos/index/'+color);
                }  
            }  
        });

    });

    //upload da imagem temporária
         $(document).on('change','#upimagem',function(){  
          
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var fd = new FormData();
            var arqs = $(this)[0].files;                      

            if(arqs.length > 0){
            // Append data 
            fd.append('imagem',$(this)[0].files[0]);
            fd.append('_token',CSRF_TOKEN);
            fd.append('_enctype','multipart/form-data');
            fd.append('_method','put');      
            
        $.ajax({                      
                type: 'POST',                             
                url:'/admin/artigos/imagemtemp-upload',
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
                            arq = arq.toString();
                        var linkimagem = "{{asset('')}}"+arq;                        
                        var imagemnova = '<header class="masthead" style="background-image: url('+linkimagem+')">';                        
                        $(".masthead").replaceWith(imagemnova);
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
        var data = new FormData();
        var arqs = $('#upimagem')[0].files;
        var color = $(this).data("color");

        if(arqs.length > 0){        
            data.append('imagem',$('#upimagem')[0].files[0]);
            data.append('_token',CSRF_TOKEN);
            data.append('_enctype','multipart/form-data');
            data.append('_method','delete');   
             $.ajax({                      
                type: 'POST',                             
                url:'/admin/artigos/delete-imgtemp',                
                dataType: 'json',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function(response){
                    if(response.status==200){
                    $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');
                    location.replace('/admin/artigos/index/'+color);
                } 
                }                                  
            });

        }else{
            location.replace('/admin/artigos/index/'+color);
        }

    });
    //fim excluir imagem temporária pelo cancelamento    

});

</script>

@stop