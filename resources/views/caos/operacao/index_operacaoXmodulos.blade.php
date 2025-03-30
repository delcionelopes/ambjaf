@extends('adminlte::page')

@section('title', 'Operações')

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
    
    <form action="{{route('caos.operacao.index')}}" class="form-search" method="GET">
        <div class="col-sm-12">
            <div class="input-group rounded">            
            <input type="text" name="pesquisa" class="form-control rounded float-left" placeholder="nome da operação" aria-label="Search"
            aria-describedby="search-addon">
            <button type="submit" class="pesquisa_btn input-group-text border-0" id="search-addon" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="bottom" data-toggle="popover" title="Pesquisa<br>Informe e tecle ENTER">
                <i class="fas fa-search"></i>
            </button>            
            
            <a href="{{route('caos.operacao.create')}}" type="button" class="AddOperacaoModal_btn input-group-text border-0 animate__animated animate__bounce" style="background: transparent;border: none; white-space: nowrap;" data-html="true" data-placement="top" data-toggle="popover" title="Novo registro"><i class="fas fa-plus"></i></a>
            
            </div>            
            </div>        
            </form>                     
  
    </section>    
            
                    <table class="table table-hover">
                        <thead class="sidebar-dark-primary" style="color: white">
                            <tr>                                
                                <th scope="col">OPERAÇÕES</th>
                                <th scope="col">ICO</th>
                                <th scope="col">MÓDULOS</th>
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody id="lista_operacao">
                        <tr id="novo" style="display:none;"></tr>
                        @forelse($operacoes as $operacao)   
                            <tr id="operacao{{$operacao->id}}">
                                <th scope="row">{{$operacao->nome}}</th>
                                @if($operacao->ico)                 
                                <td>  
                                <img src="{{asset('storage/'.$operacao->ico)}}" alt="Icone de {{$operacao->nome}}"
                                class="rounded-circle" width="100">                                
                                </td>                               
                                @else
                                <td><img src="{{asset('storage/user.png')}}" alt="Sem imagem"
                                class="rounded-circle" width="100"></td>
                                @endif                                                               
                                <td>
                                <div class="btn-group">                                
                                        @if($operacao->modulos->count())                                
                                        <button type="button" class="btn btn-none dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-tools"></i><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" id="dropdown{{$operacao->id}}">
                                            @foreach($operacao->modulos as $modulo)                                                                                                            
                                            <li class="dropdown-item"><a href="{{route('caos.operacao.operacaoxmodulo',['modulo_id'=>$modulo->id])}}" class="dropdown-item">{{$modulo->nome}}</a></li>
                                            @endforeach
                                        </ul>                                           
                                        @endif                               
                                </div>       
                                </td>
                                <td>                                    
                                        <div class="btn-group">                                           
                                            <a href="{{route('caos.operacao.edit',['id'=>$operacao->id])}}" type="button" data-id="{{$operacao->id}}" class="edit_operacao fas fa-edit" style="color: black; background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="left" data-toggle="popover" title="Editar"></a>
                                            <button type="button" data-id="{{$operacao->id}}" data-nome="{{$operacao->nome}}" class="delete_operacao_btn fas fa-trash" style="background:transparent;border:none; white-space: nowrap;" data-html="true" data-placement="right" data-toggle="popover" title="Excluir"></button>
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
                    {{$operacoes->links()}}
                    </div>  
   
    </div>        
    
</div>
@endauth
<!--End Index-->
@stop

@section('css')

<link href="{{asset('css/styles.css')}}" rel="stylesheet"/>  {{-- css da aplicação --}}
    
@stop

@section('js')

<script type="text/javascript">

$(document).ready(function(){

     $(document).on('click','.delete_operacao_btn',function(e){   ///inicio delete 
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
                imageUrl: linklogo+'/logo.png',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'logo do sistema',
                showCancelButton: true,
                confirmButtonText: 'Sim, prossiga!',                
                cancelButtonText: 'Não, cancelar!',                                 
             }).then((result)=>{
             if(result.isConfirmed){                             
                $.ajax({
                    url: '/caos/operacao/delete-operacao/'+id,
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        'id': id,                                         
                        '_token':CSRF_TOKEN,
                        '_method':'delete',
                    },
                    success:function(response){
                        if(response.status==200){                        
                            //remove linha correspondente da tabela html
                            $('#operacao'+id).remove();     
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
        $(".AddOperacaoModal_btn").tooltip();
        $(".pesquisa_btn").tooltip();        
        $(".delete_operacao_btn").tooltip();
        $(".edit_operacao").tooltip();    
    });
    ///fim tooltip


});

</script>

@stop