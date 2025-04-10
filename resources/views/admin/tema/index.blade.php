@extends('adminlte::page')

@section('title', 'Temas')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--AddTemaModal-->

<div class="modal fade animate__animated animate__bounce animate__faster" id="AddTemaModal" tabindex="-1" role="dialog" aria-labelledby="addtitleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}">
                <h5 class="modal-title" id="addtitleModalLabel" style="color: white;">Adicionar Tema</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="addform" name="addform" class="form-horizontal" role="form">                 
                <ul id="saveform_errList"></ul>                   
                <div class="form-group mb-3">
                    <label for="addtitulo">Título</label>
                    <input type="text" id="addtitulo" class="titulo form-control">
                </div>                                
                <div class="form-group mb-3">
                    <label for="adddescricao">Descrição</label>
                    <input type="text" id="adddescricao" class="descricao form-control">
                </div>                
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-{{$color}} add_tema"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>

</div>
<!--End AddTemaModal-->

<!--EditTemaModal-->

<div class="modal fade animate__animated animate__bounce" id="editTemaModal" tabindex="-1" role="dialog" aria-labelledby="edittitleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-{{$color}}">
                <h5 class="modal-title" id="edittitleModalLabel" style="color: white;">Editar e atualizar Tema</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="editform" name="editform" class="form-horizontal" role="form">                
                <ul id="updateform_errList"></ul>               
                <input type="hidden" id="edit_tema_id">
                <div class="form-group mb-3">
                    <label for="edit_titulo">Título</label>
                    <input type="text" id="edit_titulo" class="titulo form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="edit_descricao">Descrição</label>
                    <input type="text" id="edit_descricao" class="descricao form-control">
                </div>                
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-{{$color}} update_tema"><img id="imgedit" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
            </div>
        </div>
    </div>
</div>

<!--End editTemaModal -->

<!--index-->
@auth
<div class="container-fluid py-5">   
    <div id="success_message"></div>    

    <section class="border p-4 mb-4 d-flex align-items-left">
    
    <form action="{{route('admin.tema.index',['color'=>$color])}}" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">            
            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="título do tema" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                <i class="fas fa-search"></i>
            </button>        
            <button type="button" class="AddTemaModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro"><i class="fas fa-plus"></i></button>
            </div>            
            </div>        
            </form>                     
  
    </section>    
            
                    <table class="table table-hover">
                        <thead class="bg-{{$color}}" style="color: white">
                            <tr>                                
                                <th scope="col">TEMAS</th>
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_tema">
                        <tr id="novo" style="display:none;"></tr>
                        @forelse($temas as $tema)   
                            <tr id="tema{{$tema->id}}">                                
                                <th scope="row">{{$tema->titulo}}</th>                                
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <button type="button" data-id="{{$tema->id}}" class="edit_tema fas fa-edit" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar"></button>
                                            <button type="button" data-id="{{$tema->id}}" data-titulo="{{$tema->titulo}}" class="delete_tema_btn fas fa-trash" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir"></button>
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
                    {{$temas->links()}}
                    </div>  
   
    </div>        
    
</div>
@endauth

@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
    <link href="{{asset('css/styles.css')}}" rel="stylesheet"/>
@stop

@section('js')

<script type="text/javascript">

$(document).ready(function(){        
    
        $(document).on('click','.delete_tema_btn',function(e){   ///inicio delete
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
                imageAlt: 'imagem do webdojo',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){             
                $.ajax({
                    url: '/admin/tema/delete/'+id,
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
                            $("#tema"+id).remove();     
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
        //início da exibição do form
        $('#editTemaModal').on('shown.bs.modal',function(){
            $('#edit_titulo').focus();
        });
        $(document).on('click','.edit_tema',function(e){  
            e.preventDefault();
            
            var id = $(this).data("id");                                   
            $('#editform').trigger('reset');
            $('#editTemaModal').modal('show');          
            $('#updateform_errList').replaceWith('<ul id="updateform_errList"></ul>');
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: '/admin/tema/edit/'+id,                                
                success: function(response){           
                    if(response.status==200){                           
                        $('.titulo').val(response.tema.titulo);                        
                        $('.descricao').val(response.tema.descricao);
                        $('#edit_tema_id').val(response.tema.id);
                    }      
                }
            });
    
        }); //fim da da exibição do form
    
        $(document).on('click','.update_tema',function(e){ //inicio da atualização de registro
            e.preventDefault();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            var loading = $('#imgedit');
                loading.show();
    
            var id = $('#edit_tema_id').val();        
    
            var data = {
                'titulo' : $('#edit_titulo').val(),
                'descricao' : $('#edit_descricao').val(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }
            
            $.ajax({     
                type: 'POST',                          
                data: data,
                dataType: 'json',    
                url: '/admin/tema/update/'+id,         
                success: function(response){                                                    
                    if(response.status==400){
                        //erros
                        $('#updateform_errList').replaceWith('<ul id="updateform_errList"></ul>');
                        $('#updateform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#updateform_errList').append('<li>'+err_values+'</li>');
                        });    
                       loading.hide();
    
                    } else if(response.status==404){
                        $('#updateform_errList').replaceWith('<ul id="updateform_errList"></ul>');    
                        $('#success_message').replaceWith('<div id="success_message"></div>');             
                        $('#success_message').addClass('alert alert-warning');
                        $('#success_message').text(response.message);
                        loading.hide();
                    } else {
                        $('#updateform_errList').replaceWith('<ul id="updateform_errList"></ul>');      
                        $('#success_message').replaceWith('<div id="success_message"></div>');                 
                        $('#success_message').addClass("alert alert-success");
                        $('#success_message').text(response.message);                             
                        
                        loading.hide();
                        $('#editform').trigger('reset');
                        $('#editTemaModal').modal('hide');                  
                        
                        //atualizando a linha na tabela html                      
                        var linha = "";
                            linha = '<tr id="tema'+response.tema.id+'">\
                                    <th scope="row">'+response.tema.titulo+'</th>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.tema.id+'" class="edit_tema fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.tema.id+'" data-titulo="'+response.tema.titulo+'" class="delete_tema_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';                             
                        $("#tema"+id).replaceWith(linha);                                                                                
    
                    }
                }
            });    
    
        
    
        }); //fim da atualização do registro
    
        //exibe form de adição de registro
        $('#AddTemaModal').on('shown.bs.modal',function(){
            $('.titulo').focus();
        });
        $(document).on('click','.AddTemaModal_btn',function(e){  //início da exibição do form
            e.preventDefault();       
            
            $('#addform').trigger('reset');
            $('#AddTemaModal').modal('show'); 
            $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');
        });
    
        //fim exibe form de adição de registro
    
        $(document).on('click','.add_tema',function(e){ //início da adição de Registro
            e.preventDefault();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');  
            
            var loading = $('#imgadd');
                loading.show();
            var data = {
                'titulo': $('.titulo').val(),
                'descricao': $('.descricao').val(),
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            } 
            
            $.ajax({
                type: 'POST',
                url: '/admin/tema/store',
                data: data,
                dataType: 'json',
                success: function(response){
                    if(response.status==400){
                        $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');
                        $('#saveform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveform_errList').append('<li>'+err_values+'</li>');
                        });
                        loading.hide();
                    } else {
                        $('#saveform_errList').replaceWith('<ul id="saveform_errList"></ul>');     
                        $('#success_message').replaceWith('<div id="success_message"></div>');              
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);     
                        
                        loading.hide();
                        $('#addform').trigger('reset');                    
                        $('#AddTemaModal').modal('hide');
    
                        //adiciona a linha na tabela html                      
                            
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<tr id="novo" style="display:none;"></tr>';
                            linha1 = '<tr id="tema'+response.tema.id+'">\
                                    <th scope="row">'+response.tema.titulo+'</th>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.tema.id+'" class="edit_tema fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.tema.id+'" data-titulo="'+response.tema.titulo+'" class="delete_tema_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';
                        if(!$('#nadaencontrado').html==""){
                            $('#nadaencontrado').remove();
                        }
                        tupla = linha0+linha1;                             
                        $("#novo").replaceWith(tupla);                                                     
                        
                    }
                    
                }
            });
    
        }); //Fim da adição de registro
    
    ///tooltip
    $(function(){             
        $(".AddTemaModal_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_tema_btn").tooltip();
        $(".edit_tema").tooltip();    
    });
    ///fim tooltip
    
    
    }); ///Fim do escopo do script
    
    </script>
@stop