@extends('adminlte::page')

@section('title', 'meuBairroADMIN')

@section('content')

<style>
    .tooltip-inner {
    text-align: left;
}
</style>

<!--index-->
@auth
<div class="container-fluid py-5">   
    <div id="success_message"></div>    

    <section class="border p-4 mb-4 d-flex align-items-left">
    
    <form action="{{route('admin.entidades.index',['color'=>$color])}}" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">            
            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="título" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                <i class="fas fa-search"></i>
            </button>        
            <a href="{{route('admin.entidades.create',['color'=>$color])}}" type="button" class="AddEntidade_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro"><i class="fas fa-plus"></i></a>
            </div>            
            </div>        
            </form>                     
  
    </section>    
            
                    <table class="table table-hover">
                        <thead class="pg-{{$color}}" style="color: white">
                            <tr>                                
                                <th scope="col">ENTIDADE</th>                                
                                <th scope="col">SIGLA</th>                                
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_artigos">
                        <tr id="novo" style="display:none;"></tr>
                        @forelse($entidades as $entidade)   
                            <tr id="entidade{{$entidade->id}}">                                
                                <th scope="row">{{$entidade->nome}}</th>                                
                                <td>{{$entidade->sigla}}</td>
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <a href="{{route('admin.entidades.edit',['id'=>$entidade->id,'color'=>$color])}}" type="button" data-id="{{$entidade->id}}" class="edit_entidade fas fa-edit" style="background:transparent;border:none; color:black; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar"></a>
                                            <button type="button" data-id="{{$entidade->id}}" data-sigla="{{$entidade->sigla}}" class="delete_entidade_btn fas fa-trash" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir"></button>
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
                    {{$entidades->links()}}
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
    
        $(document).on('click','.delete_entidade_btn',function(e){   ///inicio delete 
            e.preventDefault();           
            var CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');   
            var id = $(this).data("id");    
            var linklogo = "{{asset('storage')}}";        
            var sigla = $(this).data("sigla");
            
            Swal.fire({
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                title:sigla,
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
                    url: '/admin/entidades/delete/'+id,
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
                            $("#entidade"+id).remove();     
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
    

    ///tooltip
    $(function(){             
        $(".AddEntidade_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_entidade_btn").tooltip();
        $(".edit_entidade").tooltip();    
    });
    ///fim tooltip
    
    
    }); ///Fim do escopo do script
    
    </script>
@stop