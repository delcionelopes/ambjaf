@extends('adminlte::page')

@section('title', 'meublogADMIN')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--index-->
<div class="container-fluid py-5">   
    <div id="success_message"></div>    

    <section class="border p-4 mb-4 d-flex align-items-left">
    
    <form action="{{route('admin.user.index')}}" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">            
            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="nome do usuário" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                <i class="fas fa-search"></i>
            </button>            
            
            <a href="{{route('admin.user.create')}}" type="button" class="AddUsuario_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro"><i class="fas fa-plus"></i></a>
            
            </div>            
            </div>        
            </form>                     
  
    </section>    
            
                    <table class="table table-hover">
                        <thead class="sidebar-dark-primary elevation-4" style="color: white">
                            <tr>                                
                                <th scope="col">USUÁRIOS</th>
                                <th scope="col">AVATAR</th>                                
                                <th scope="col">ADMIN</th>
                                <th scope="col">ATIVO</th>
                                <th scope="col">ATUALIZAÇÃO</th>
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_usuario">
                        <tr id="novo" style="display:none;"></tr>
                        @forelse($users as $user)   
                            <tr id="user{{$user->id}}">                                
                                <th scope="row">{{$user->name}}</th>
                                @if($user->avatar)                 
                                <td>  
                                <img src="{{asset('storage/'.$user->avatar)}}" alt="Foto de {{$user->name}}"
                                class="rounded-circle" width="100">                                
                                </td>                               
                                @else
                                <td><img src="{{asset('storage/user.png')}}" alt="Sem foto"
                                class="rounded-circle" width="100"></td>
                                @endif                                
                                @if($user->admin)
                                <td id="admin{{$user->id}}"><button type="button" data-id="{{$user->id}}" data-admin="0" class="admin_user fas fa-thumbs-up" style="background: transparent; color: green; border: none;"></button></td>
                                @else
                                <td id="admin{{$user->id}}"><button type="button" data-id="{{$user->id}}" data-admin="1" class="admin_user fas fa-thumbs-down" style="background: transparent; color: red; border: none;"></button></td>
                                @endif
                                @if($user->inativo)
                                <td id="inativo{{$user->id}}"><button type="button" data-id="{{$user->id}}" data-inativo="0" class="inativo_user fas fa-thumbs-down" style="background: transparent; color: red; border: none;"></button></td>
                                @else
                                <td id="inativo{{$user->id}}"><button type="button" data-id="{{$user->id}}" data-inativo="1" class="inativo_user fas fa-thumbs-up" style="background: transparent; color: green; border: none;"></button></td>
                                @endif
                                 @if(is_null($user->updated_at))
                                <td>NOVO</td>
                                @else
                                <td>{{date('d/m/Y H:i:s',strtotime($user->updated_at))}}</td>
                                @endif
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <a href="{{route('admin.user.edit',['id'=>$user->id])}}" type="button" data-id="{{$user->id}}" class="edit_usuario_btn fas fa-edit" style="color: black; background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar"></a>
                                            <button type="button" data-id="{{$user->id}}" data-nome="{{$user->name}}" class="delete_usuario_btn fas fa-trash" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir"></button>
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
                    {{$users->links()}}
                    </div>  
   
    </div>        
    
</div> 
<!--End Index-->
@stop

@section('css')

<link href="{{asset('css/styles.css')}}" rel="stylesheet"/>
    
@stop

@section('js')

<script type="text/javascript">

$(document).ready(function(){

     $(document).on('click','.delete_usuario_btn',function(e){   ///inicio delete 
            e.preventDefault();           
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
            var id = $(this).data("id");
            var linklogo = "{{asset('storage')}}";

            var nome = $(this).data("nome");
            
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
                    url: '/admin/user/delete/'+id,
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        'id': id,                                         
                        '_token':CSRF_TOKEN,
                        '_method':'DELETE',
                    },
                    success:function(response){
                        if(response.status==200){                        
                            //remove linha correspondente da tabela html
                            $("#user"+id).remove();     
                            $('#success_message').replaceWith('<div id="success_message"></div>');                       
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);         
                        }else{
                            //Não pôde excluir por causa dos relacionamentos    
                            $('#success_message').replaceWith('<div id="success_message"></div>');                                                    
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        }
                    }
                }); 
            }  
        });        
       
      
    });  ///fim delete

    //inicio admin usuario
    $(document).on('click','.admin_user',function(e){
        e.preventDefault();
        var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
        var id = $(this).data("id");        
        var admin = $(this).data("admin");
        
        var data = {
            'admin':admin,
            '_token':CSRF_TOKEN,
            '_method':'PUT',
        }        
            $.ajax({
                type: 'post',
                dataType: 'json',
                data:data,
                url:'/admin/user/admin/'+id,
                success: function(response){
                    if(response.status==200){                                                                               
                        var limita1 = "";
                        var limita2 = "";                        
                        if(response.user.admin==1){
                        limita1 = '<td id="admin'+response.user.id+'"><button type="button"\
                                   data-id="'+response.user.id+'" \
                                   data-admin="0" \
                                   class="admin_user fas fa-thumbs-up"\
                                   style="background: transparent; color: green; border: none;">\
                                   </button></td>';
                                }else{
                        limita2 = '<td id="admin'+response.user.id+'"><button type="button" \
                                   data-id="'+response.user.id+'" \
                                   data-admin="1" \
                                   class="admin_user fas fa-thumbs-down" \
                                   style="background: transparent; color: red; border: none;">\
                                   </button></td>';
                                }
                        var celula = limita1+limita2;
                        $('#admin'+id).replaceWith(celula);
                    }
                }
            });
    });
    //fim admin usuario

    //inicio inativa usuario
    $(document).on('click','.inativo_user',function(e){
        e.preventDefault();
        var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var id = $(this).data("id");
        var inativo = $(this).data("inativo");
        var data = {
            'inativo':inativo,
            '_token':CSRF_TOKEN,
            '_method':'PUT',
        }        
            $.ajax({
                type: 'post',
                dataType: 'json',
                data:data,
                url:'/admin/usuario/inativo/'+id,
                success: function(response){
                    if(response.status==200){                                                                               
                        var limita1 = "";
                        var limita2 = "";                        
                        if(response.user.inativo==1){
                        limita1 = '<td id="inativo'+response.user.id+'"><button type="button" \
                                  data-id="'+response.user.id+'" \
                                  data-inativo="0" \
                                  class="inativo_user fas fa-thumbs-down" \
                                  style="background: transparent; color: red; border: none;">\
                                  </button></td>';
                        }else{
                        limita1 = '<td id="inativo'+response.user.id+'"><button type="button" \
                                   data-id="'+response.user.id+'" \
                                   data-inativo="1" \
                                   class="inativo_user fas fa-thumbs-up" \
                                   style="background: transparent; color: green; border: none;">\
                                   </button></td>';
                        }
                        var celula = limita1+limita2;
                        $('#inativo'+id).replaceWith(celula);        
                    }
                }
            });
        });
        //fim inativa usuario

    ///tooltip
    $(function(){             
        $(".AddUsuario_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_usuario_btn").tooltip();
        $(".edit_usuario_btn").tooltip();    
    });
    ///fim tooltip

}); //fim do escopo geral

</script>

@stop