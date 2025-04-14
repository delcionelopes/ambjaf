@extends('adminlte::page')

@section('title', 'PERFIL')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--AddPerfilModal-->

<div class="modal fade animate__animated animate__bounce animate__faster" id="AddPerfilModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Adicionar Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="addform" name="addform" class="form-horizontal" role="form">                 
                <ul id="saveform_errList"></ul>                   
                <div class="form-group mb-3">
                    <label for="">Nome</label>
                    <input type="text" class="nome_perfil form-control">
                </div>                                
            </form>            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_perfil"><img id="imgadd" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Salvar</button>
            </div>
        </div>
    </div>

</div>
<!--End AddPerfilModal-->

<!--EditPerfilModal-->

<div class="modal fade animate__animated animate__bounce animate__faster" id="editPerfilModal" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="titleModalLabel" style="color: white;">Editar e atualizar Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="editform" name="editform" class="form-horizontal" role="form">                
                <ul id="updateform_errList"></ul>               
                <input type="hidden" id="edit_perfil_id">
                <div class="form-group mb-3">
                    <label for="edit_nome_perfil">Nome</label>
                    <input type="text" id="edit_nome_perfil" class="nome_perfil form-control">
                </div>                         
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_perfil"><img id="imgedit" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Atualizar</button>
            </div>
        </div>
    </div>
</div>


<!--Begin ListAuthorizationModal-->

<div class="modal fade animate__animated animate__bounce" id="ListAuthorizationModal" tabindex="-1" role="dialog" aria-labelledby="listtitleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header navbar-dark bg-primary">
                <h5 class="modal-title" id="listtitleModalLabel" style="color: white;">Perfil: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>                
            </div>
            <div class="modal-body form-horizontal">
            <form id="listform" name="listform" class="form-horizontal" role="form">                
                <ul id="listform_errList"></ul>               
                <input type="hidden" id="list_perfil_id">
                <div class="card">
                     <div class="card-body" id="cardauthorizations">                            
                     </div>
                </div>                  
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_listauthorization"><img id="imglist" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"> Confirmar</button>
            </div>
        </div>
    </div>
</div>

<!--End ListAuthorizationModal -->

<!--index-->
@auth
<div class="container-fluid py-5">   
    <div id="success_message"></div>    
    <section class="border p-4 mb-4 d-flex align-items-left">    
    <form action="{{route('caos.perfil.index')}}" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">            
            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="nome do perfil" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                <i class="fas fa-search"></i>
            </button>        
            <button type="button" class="AddPerfilModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro">
                <i class="fas fa-plus"></i>
            </button>                
            </div>            
            </div>        
            </form>                     
  
    </section>    
            
                    <table class="table table-hover">
                        <thead class="sidebar-dark-primary" style="color: white">
                            <tr>                                
                                <th scope="col">PERFIS</th>
                                <th scope="col">AUTORIZAÇÕES</th>
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_perfil">
                        <tr id="novo" style="display:none;"></tr>
                        @forelse($perfis as $perfil)   
                            <tr id="perfil{{$perfil->id}}">                                
                                <th scope="row">{{$perfil->nome}}</th>                                
                                <td>
                                        <div class="btn-group">                                           
                                            <button type="button" data-id="{{$perfil->id}}" data-nome="{{$perfil->nome}}" class="list_authorizations_btn" style="background:transparent;border:none;"><i id="ico_list{{$perfil->id}}" class="fas fa-list"></i><img id="img_list{{$perfil->id}}" src="{{asset('storage/ajax-loader.gif')}}" style="display: none;" class="rounded-circle" width="20"></button>
                                        </div>    
                                </td>
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <button type="button" data-id="{{$perfil->id}}" data-nomeperfil="{{$perfil->nome}}" class="edit_perfil fas fa-edit" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar"></button>
                                            <button type="button" data-id="{{$perfil->id}}" data-nomeperfil="{{$perfil->nome}}" class="delete_perfil_btn fas fa-trash" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir"></button>
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
                    {{$perfis->links()}}
                    </div>  
   
    </div>        
    
</div>
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
    
        $(document).on('click','.delete_perfil_btn',function(e){   ///inicio delete
            e.preventDefault();          
            var linklogo = "{{asset('storage')}}";
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
            var id = $(this).data("id");            
            var nome = $(this).data("nomeperfil");
            
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:nome,
                text: "Deseja excluir?",
                imageUrl: linklogo+'/logo.jpg',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'imagem do sistema',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){             
                $.ajax({
                    url: '/caos/perfil/delete-perfil/'+id,
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
                            $("#perfil"+id).remove();     
                            $("#success_message").replaceWith('<div id="success_message"></div>');                       
                            $("#success_message").addClass('alert alert-success');
                            $("#success_message").text(response.message);         
                        }else{
                            //Não pôde excluir por causa dos relacionamentos    
                            $("#success_message").replaceWith('<div id="success_message"></div>');                        
                            $("#success_message").addClass('alert alert-danger');
                            $("#success_message").text(response.errors);         
                        }
                    }
                }); 
            } 
        });   
      
        });  ///fim delete
        //início da exibição do form EditPerfilModal
        $("#editPerfilModal").on('shown.bs.modal',function(){
            $("#edit_nome_perfil").focus();
        });
        $(document).on('click','.edit_perfil',function(e){  
            e.preventDefault();
            var linklogo = "{{asset('storage')}}";
            var id = $(this).data("id");            
            var nome = $(this).data("nomeperfil");
            
            $("#editform").trigger('reset');
            $("#editPerfilModal").modal('show');          
            $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');      
    
            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
    
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: '/caos/perfil/edit-perfil/'+id,                                
                success: function(response){           
                    if(response.status==200){                           
                        $(".nome_perfil").val(response.perfil.nome);                        
                        $("#edit_perfil_id").val(response.perfil.id);                                                                                                       
                    }      
                }
            });        
    
        }); //fim da da exibição do form EditPerfilModal
    
        $(document).on('click','.update_perfil',function(e){ //inicio da atualização de registro
            e.preventDefault();
            var loading = $("#imgedit");
                loading.show();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');            
    
            var id = $("#edit_perfil_id").val();        
    
            var data = {
                'nome' : $("#edit_nome_perfil").val(),                
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }
            
            $.ajax({     
                type: 'POST',                          
                data: data,
                dataType: 'json',    
                url: '/caos/perfil/update-perfil/'+id,         
                success: function(response){                                                    
                    if(response.status==400){
                        //erros
                        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');
                        $("#updateform_errList").addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $("#updateform_errList").append('<li>'+err_values+'</li>');
                        });
    
                        loading.hide();
    
                    } else if(response.status==404){
                        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');    
                        $("#success_message").replaceWith('<div id="success_message"></div>');             
                        $("#success_message").addClass('alert alert-warning');
                        $("#success_message").text(response.message);
                        loading.hide();
    
                    } else {
                        $("#updateform_errList").replaceWith('<ul id="updateform_errList"></ul>');      
                        $("#success_message").replaceWith('<div id="success_message"></div>');                 
                        $("#success_message").addClass("alert alert-success");
                        $("#success_message").text(response.message);
                        loading.hide();
    
                        $("#editform").trigger('reset');
                        $("#editPerfilModal").modal('hide');                  
                        
                        //atualizando a linha na tabela html                      
                            var link = "{{asset('')}}"+"storage/ajax-loader.gif"; 
                            var linha = '<tr id="perfil'+response.perfil.id+'">\
                                    <th scope="row">'+response.perfil.nome+'</th>\
                                    <td>\
                                        <div class="btn-group">\
                                            <button type="button" data-id="'+response.perfil.id+'" data-nome="'+response.perfil.nome+'" class="list_authorizations_btn" style="background:transparent;border:none;"><i id="ico_list'+response.roule.id+'" class="fas fa-list"></i><img id="img_list'+response.perfil.id+'" src="'+link+'" style="display: none;" class="rounded-circle" width="20"></button>\
                                        </div>\
                                    </td>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.perfil.id+'" data-nomeperfil="'+response.perfil.nome+'" class="edit_perfil fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.perfil.id+'" data-nomeperfil="'+response.perfil.nome+'" class="delete_perfil_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';                             
                        $("#perfil"+id).replaceWith(linha);                                                                                
    
                    }
                }
            });    
    
        
    
        }); //fim da atualização do registro
    
        //exibe form de adição de registro
        $("#AddPerfilModal").on('shown.bs.modal',function(){
            $(".nome_perfil").focus();
        });
        $(document).on('click','.AddPerfilModal_btn',function(e){  //início da exibição do form AddPerfilModal
            e.preventDefault();     
            
            var link = "{{asset('storage')}}";           
            
            $("#addform").trigger('reset');
            $("#AddPerfilModal").modal('show'); 
            $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');    
        });
    
        //fim exibe form de adição de registro
    
        $(document).on('click','.add_perfil',function(e){ //início da adição de Registro
            e.preventDefault();
            var loading = $("#imgadd");
                loading.show();
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
            var data = {
                'nome': $(".nome_perfil").val(),                
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            } 
            
            $.ajax({
                type: 'POST',
                url: '/caos/perfil/store-perfil',
                data: data,
                dataType: 'json',
                success: function(response){
                    if(response.status==400){
                        $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');
                        $("#saveform_errList").addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $("#saveform_errList").append('<li>'+err_values+'</li>');
                        });
                        loading.hide();
                    } else {
                        $("#saveform_errList").replaceWith('<ul id="saveform_errList"></ul>');     
                        $("#success_message").replaceWith('<div id="success_message"></div>');              
                        $("#success_message").addClass('alert alert-success');
                        $("#success_message").text(response.message);                                        
                        loading.hide();
                        $("#addform").trigger('reset');                    
                        $("#AddPerfilModal").modal('hide');
    
                        //adiciona a linha na tabela html
                        var link = "{{asset('')}}"+"storage/ajax-loader.gif";
                        var tupla = "";
                        var linha0 = "";
                        var linha1 = "";
                            linha0 = '<tr id="novo" style="display:none;"></tr>';
                            linha1 = '<tr id="perfil'+response.perfil.id+'">\
                                    <th scope="row">'+response.perfil.nome+'</th>\
                                    <td>\
                                        <div class="btn-group">\
                                            <button type="button" data-id="'+response.perfil.id+'" data-nome="'+response.perfil.nome+'" class="list_authorizations_btn" style="background:transparent;border:none;"><i id="ico_list'+response.perfil.id+'" class="fas fa-list"></i><img id="img_list'+response.perfil.id+'" src="'+link+'" style="display: none;" class="rounded-circle" width="20"></button>\
                                        </div>\
                                    </td>\
                                    <td><div class="btn-group">\
                                    <button type="button" data-id="'+response.perfil.id+'" data-nomeperfil="'+response.perfil.nome+'" class="edit_perfil fas fa-edit" style="background:transparent;border:none"></button>\
                                    <button type="button" data-id="'+response.perfil.id+'" data-nomeperfil="'+response.perfil.nome+'" class="delete_perfil_btn fas fa-trash" style="background:transparent;border:none"></button>\
                                    </div></td>\
                                    </tr>';
                        if(!$("#nadaencontrado").html==""){
                            $("#nadaencontrado").remove();
                        }
                        tupla = linha0+linha1;                             
                        $("#novo").replaceWith(tupla);                                                     
                        
                    }
                    
                }
            });
    
        }); //Fim da adição de registro


        ///inicio lista
         $(document).on('click','.list_authorizations_btn',function(e){
            e.preventDefault();

            var id = $(this).data("id");
                                      
                     $('#ico_list'+id).replaceWith('<i id="ico_list'+id+'"></i>');
            var loading = $('#img_list'+id);
                loading.show();

            $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });                
    
            $.ajax({ 
                type: 'GET',             
                dataType: 'json',                                    
                url: '/caos/perfil/list-authorizations/'+id,                                
                success: function(response){
                    if(response.status==200){                        
                       $('#listform_errList').replaceWith('<ul id="listform_errList"></ul>');     
                        $('#listtitleModalLabel').replaceWith('<h5 class="modal-title" id="listtitleModalLabel" style="color: white;">Perfil: '+response.perfil.nome+'</h5>');
                        $('#cardauthorizations').replaceWith('<div class="card-body" id="cardauthorizations"></div>');                        
                        var limitacard = "";
                        $.each(response.modulos,function(key,modulo){                            
                                limitacard = limitacard+
                                '<div class="card-body" id="cardauthorizations'+modulo.id+'">\
                                <fieldset>\
                                    <legend>'+modulo.nome+'</legend>\
                                    <div class="form-check" id="form-check-vinculo'+modulo.id+'">\
                                    </div>\
                                </fieldset>\
                                </div>';       
                        });
                        $('#cardauthorizations').append(limitacard);
                        
                        $.each(response.modope,function(key,modope){                        
                        $('#form-check-vinculo'+modope.modulo_id).append('<label class="form-check-label" for="check'+modope.id+'">\
                            <input type="checkbox" id="check'+modope.id+'" name="authorizations[]" value="'+modope.id+'" class="form-check-input">\
                            '+modope.operacao.nome+'</label><br>');
                        });     
                        
                       
                        $("input[name='authorizations[]']").attr('checked',false);
                        
                        $.each(response.authorizations,function(key,authorization){                                                                                    
                                $("#check"+authorization.modope_id).attr('checked',true);
                        });

                        

                        $('#listmyform').trigger('reset');                    
                        $('#ListAuthorizationModal').modal('show');                       

                        $('#listform_errList').replaceWith('<ul id="listform_errList"></ul>');   
                        $('#list_perfil_id').val(id);
                        loading.hide();
                        $('#ico_list'+id).replaceWith('<i id="ico_list'+id+'" class="fas fa-list"></i>');
                          
                    }else{
                       var message = '<div class="card-body" id="cardauthorizations">\
                                <fieldset>\
                                    <legend>'+response.message+'</legend>\
                                </fieldset>\
                                </div>';
                        $('#cardauthorizations').replaceWith('<div class="card-body" id="cardauthorizations"></div>');
                        $('#cardauthorizations').append(message);
                        $('#listmyform').trigger('reset');
                        $('#ListAuthorizationModal').modal('show');                        

                        $('#listform_errList').replaceWith('<ul id="listform_errList"></ul>');   
                        $('#list_perfil_id').val(id);
                        loading.hide();
                        $('#ico_list'+id).replaceWith('<i id="ico_list'+id+'" class="fas fa-list"></i>');
                    }
                }
            });
        });

        $(document).on('click','.update_listauthorization',function(e){
            e.preventDefault();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var loading = $('#imglist');
                loading.show();
            var id = $('#list_perfil_id').val();
            
            var authorizations = new Array;
                        $("input[name='authorizations[]']:checked").each(function(){                
                            authorizations.push($(this).val());
                        });   
            var data = {
                'id':id,
                'permissoes':authorizations,
                '_method':'PUT',
                '_token':CSRF_TOKEN,
            }
            
            $.ajax({
                url:'/caos/perfil/store-authorizations/'+id,
                type:'POST',
                dataType:'json',
                data:data,
                success:function(response){
                    if(response.status==400){
                        $('#listform_errList').replaceWith('<ul id="listform_errList"></ul>');
                        $('#listform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#listform_errList').append('<li>'+err_values+'</li>');
                        });
                        loading.hide();
                    } else {
                        $('#listform_errList').replaceWith('<ul id="listform_errList"></ul>');     
                        $('#success_message').replaceWith('<div id="success_message"></div>');              
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);                                        
                        loading.hide();
                        $('#listmyform').trigger('reset');
                        $('#ListAuthorizationModal').modal('hide');
                    }
                }
            });
        }); 

        ///fim lista de autorizações



    ///tooltip
    $(function(){             
        $(".AddPerfilModal_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_perfil_btn").tooltip();
        $(".edit_perfil").tooltip();    
    });
    ///fim tooltip

    
    }); ///Fim do escopo do script
    
    </script>
@stop