@extends('adminlte::page')

@section('title', 'meublogADMIN')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--index-->
@auth
@if(!(auth()->user()->inativo))
<div class="container-fluid py-5">   
    <div id="success_message"></div>    

    <section class="border p-4 mb-4 d-flex align-items-left">
    
    <form action="{{route('admin.artigos.index')}}" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">            
            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="título" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                <i class="fas fa-search"></i>
            </button>        
            <a href="{{route('admin.artigos.create')}}" type="button" class="AddArtigo_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro"><i class="fas fa-plus"></i></a>
            </div>            
            </div>        
            </form>                     
  
    </section>    
            
                    <table class="table table-hover">
                        <thead class="sidebar-dark-primary" style="color: white">
                            <tr>                                
                                <th scope="col">ARTIGOS</th>                                
                                <th scope="col">DOC(s)</th>                                
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_artigos">
                        <tr id="novo" style="display:none;"></tr>
                        @forelse($artigos as $artigo)   
                            <tr id="artigo{{$artigo->id}}">                                
                                <th scope="row">{{$artigo->titulo}}</th>                                
                                <td>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="btn-group" id="docs{{$artigo->id}}">                                                                        
                                        <button type="button" class="btn btn-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-file-pdf"></i><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" id="listdocs{{$artigo->id}}">
                                        <li class="dropdown-item files_enviar_btn" data-id="{{$artigo->id}}">
                                             <span class="btn btn-primary fileinput-button"><i class="fas fa-folder-open" style="color: red"></i>
                                                <input data-id="{{$artigo->id}}" id="arquivo{{$artigo->id}}" class="arquivo" type="file" name="arquivo[]" accept="application/pdf" multiple>
                                             </span>  
                                        </li>
                                            @foreach($artigo->arquivos as $doc)
                                            <li id="doc{{$doc->id}}" class="dropdown-item">                                                 
                                                    <a href="#!" id="btn_excluir_doc" data-id="{{$doc->id}}" data-filename="{{$doc->rotulo}}" class="fas fa-trash" style="color: red"></a>
                                                    <a href="#!" id="btn_abrir_doc" data-id="{{$doc->id}}" type="button" class="btn btn-none" style="color: blue">{{$doc->rotulo}}</a>
                                            </li>                                            
                                            @endforeach                                        
                                        </ul>                                        
                                    </div>     
                                    </form>
                                </td>                                
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <a href="{{route('admin.artigos.edit',['id'=>$artigo->id])}}" type="button" data-id="{{$artigo->id}}" class="edit_artigo fas fa-edit" style="background:transparent;border:none; color:black; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar"></a>
                                            <button type="button" data-id="{{$artigo->id}}" data-titulo="{{$artigo->titulo}}" class="delete_artigo_btn fas fa-trash" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir"></button>
                                        </div>                                    
                                </td>
                            </tr>  
                            @empty
                            <tr id="nadaencontrado">
                                <td colspan="4">Nada Encontrado!</td>
                            </tr>                      
                            @endforelse                                                    
                        </tbody>
                    </table> 
                    <div class="d-flex hover justify-content-center">
                    {{$artigos->links()}}
                    </div>  
   
    </div>        
    
</div> 
@else 
  <i class="fas fa-lock"></i><b class="title"> USUÁRIO INATIVO OU NÃO LIBERADO! CONTACTE O ADMINISTRADOR.</b>
@endif
@endauth
<!--End Index-->
@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
    <link href="{{asset('css/styles.css')}}" rel="stylesheet"/>
@stop

@section('js')

<script type="text/javascript">

$(document).ready(function(){        
    
        $(document).on('click','.delete_artigo_btn',function(e){   ///inicio delete 
            e.preventDefault();           
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
            var id = $(this).data("id");    
            var linklogo = "{{asset('storage')}}";        
            var titulo = $(this).data("titulo");
            
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:titulo,
                text: "Deseja excluir?",
                imageUrl: linklogo+'/logo.png',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do sistema',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){             
                $.ajax({
                    url: '/admin/artigos/delete/'+id,
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        'id': id,
                        '_method': 'DELETE',                    
                        '_token':CSRF_TOKEN,
                    },
                    success:function(response){
                        if(response.status==200){                        
                            //remove linha correspondente da tabela html
                            $("#artigo"+id).remove();     
                            $('#success_message').replaceWith('<div id="success_message"></div>');                       
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);         
                        }else{
                            //Não pôde excluir por causa dos relacionamentos    
                            $('#success_message').replaceWith('<div id="success_message"></div>');                        
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.errors);
                        }
                    }
                });            
            }  
        });
      
        });  ///fim delete        

    //inicio enviar docs
    $(document).on('change','.arquivo',function(){
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var formData = new FormData();            
            let id = $(this).data('id');      
            let TotalFiles = $('#arquivo'+id)[0].files.length;
            let files = $('#arquivo'+id)[0];    

            for(let i=0; i < TotalFiles; i++){
                formData.append('arquivo'+i, files.files[i]);                            
            }

            formData.append('TotalFiles',TotalFiles);                    
            formData.append('_token',CSRF_TOKEN);
            formData.append('_enctype','multipart/form-data');
            formData.append('_method','PUT'); 
            
            $('.arquivo').val(""); ///limpa o input
                                
            $.ajax({                                             
                url: '/admin/artigos/upload-docs/'+id,              
                type:'POST',
                dataType: 'json',        
                data:formData,
                cache:false,        
                contentType: false,        
                processData: false, 
                async: true,       
                success: function(response){                              
                if(response.status==200){                      
                      $.each(response.arquivos,function(key,docs){  
                        $('#doc'+docs.id).remove();                                                                                                         
                        $('#listdocs'+id).append('<li id="doc'+docs.id+'" class="dropdown-item">\
                                                    <a href="#!" id="btn_excluir_doc" data-id="'+docs.id+'" data-filename="'+docs.rotulo+'" class="fas fa-trash" style="color: red"></a>\
                                                    <a href="#!" id="btn_abrir_doc" data-id="'+docs.id+'" type="button" class="btn btn-none" style="color: blue">'+docs.rotulo+'</a>\
                                                  </li>');
                      });       
                }   
                }                                  
        });  
    });
    ////fim enviar docs
    ///delete doc
     $(document).on('click','#btn_excluir_doc',function(e){ 
            e.preventDefault();           
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var id = $(this).data("id");            
            var nome = $(this).data("filename");
            
                      
                $.ajax({
                    url: '/admin/artigos/delete-docs/'+id,
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        'id': id,
                        '_method': 'DELETE',                    
                        '_token':CSRF_TOKEN,
                    },
                    success:function(response){
                        if(response.status==200){                        
                            $('#doc'+id).remove();
                        }
                    }
                });            
      
      
        }); 
    ///fim delete doc
    ////Abrir doc
    $(document).on('click','#btn_abrir_doc',function(e){
        e.preventDefault();            
            var id = $(this).data("id"); 

               $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: '/admin/artigos/abrir-doc/'+id,                                
                success: function(response){ 
                    if(response.status==200){
                      var link = '{{asset('')}}'+'storage/'+response.arquivo.path;
                      //visualizar o pdf no browser                
                          window.open(link);                    
                    }
                }
            });

    });
    ///fim abrir doc   

    ///tooltip
    $(function(){             
        $(".AddArtigo_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_artigo_btn").tooltip();
        $(".edit_artigo").tooltip();    
    });
    ///fim tooltip
    
    
    }); ///Fim do escopo do script
    
    </script>
@stop