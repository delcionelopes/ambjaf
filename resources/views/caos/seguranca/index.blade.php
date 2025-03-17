@extends('adminlte::page')

@section('title', 'Segurança')

@section('content')

<style>
.card {
    transition: transform 0.2s ease;
    box-shadow: 0 4px 6px 0 rgba(22, 22, 26, 0.18);
    border-radius: 0;
    border: 0;
    margin-bottom: 1.5em;
  }
  .card:hover {
    transform: scale(1.1);
  }
</style>

<div class="container-fluid py-5"> 

            <div class="card p-3" style="background-image: url('/assets/img/banner-docs.jpg')">
                <div class="d-flex align-items-center">
                <div class="image">
                @if(auth()->user()->avatar)  
                <img src="{{asset('storage/'.auth()->user()->avatar)}}" class="rounded-circle" width="100" >
                @else
                <img src="{{asset('storage/user.png')}}" class="rounded-circle" width="100" >
                @endif
                </div>
                <div class="ml-3 w-100">                    
                   <h4 class="mb-0 mt-0" style="color: red" ><b>{{auth()->user()->name}}</b></h4>                 
                </div>                    
                </div>              
            </div>         
<div class="container-fluid">
 <div class="row">    
  @if((auth()->user()->admin)&&(auth()->user()->perfil_id==3))  
  <div class="p-2 mt-2">
    <div class="card" style="width: 10rem;">
      <div class="card-header">
        <b><i class="fas fa-desktop" style="background: transparent; color: red; border: none;"></i> Módulos</b>
      </div>
      <div class="card-body">                
        <p class="card-text">Cadastro básico.</p>        
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Menu<span class="caret"></span>
                                </button>                                
                                <ul class="dropdown-menu" id="dropdown_modulo{{auth()->user()->id}}">
                                            <li class="dropdown-item"><a href="{{route('caos.modulo.index')}}" class="dropdown-item listamodulo_btn"  
                                                style="white-space: nowrap;"><i class="fas fa-list" style="background: transparent; color: red; border: none;"></i> Cadastro de módulos</a>
                                            </li> 
                                </ul>  
      </div>
    </div>
  </div>  

   <div class="p-2 mt-2">
    <div class="card" style="width: 10rem;">
      <div class="card-header">
        <b><i class="fas fa-desktop" style="background: transparent; color: red; border: none;"></i> Operações</b>
      </div>
      <div class="card-body">                
        <p class="card-text">Cadastro básico.</p>        
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Menu<span class="caret"></span>
                                </button>                                
                                <ul class="dropdown-menu" id="dropdown_operacao{{auth()->user()->id}}">
                                            <li class="dropdown-item"><a href="{{route('caos.operacao.index')}}" class="dropdown-item listaoperacao_btn"
                                                style="white-space: nowrap;"><i class="fas fa-list" style="background: transparent; color: red; border: none;"></i> Cadastro de operações</a>
                                            </li> 
                                </ul>  
      </div>
    </div>
  </div> 

  <div class="p-2 mt-2">
        <div class="card" style="width: 10rem;">
          <div class="card-header">
            <b><i class="fas fa-desktop" style="background: transparent; color: red; border: none;"></i> Permissões</b>
          </div>
          <div class="card-body">                
            <p class="card-text">Autorizações.</p>
            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Opções<span class="caret"></span>
                                </button>                                
                                <ul class="dropdown-menu" id="dropdown_opcoes{{auth()->user()->id}}">
                                            <li class="dropdown-item"><a href="{{route('caos.perfil.index')}}" class="dropdown-item listaperfil_btn"  
                                                style="white-space: nowrap;"><i class="fas fa-folder" style="background: transparent; color: red; border: none;"></i> Cadastro de Perfis</a>
                                            </li>                                             
                                            <li class="dropdown-item"><a href="{{route('admin.user.index')}}" class="dropdown-item listaousuarios_btn"  
                                                style="white-space: nowrap;"><i class="fas fa-user" style="background: transparent; color: red; border: none;"></i> Cadastro de Usuários</a>
                                            </li> 
                                </ul>
          </div>
        </div>
      </div>  

  @elseif((auth()->user()->admin) && (auth()->user()->perfil_id!=3))

        <div class="p-2 mt-2">
        <div class="card" style="width: 10rem;">
          <div class="card-header">
            <b><i class="fas fa-desktop" style="background: transparent; color: red; border: none;"></i> Permissões</b>
          </div>
          <div class="card-body">                
            <p class="card-text">Autorizações.</p>        
            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Opções<span class="caret"></span>
                                </button>                                
                                <ul class="dropdown-menu" id="dropdown_opcoes{{auth()->user()->id}}">
                                            <li class="dropdown-item"><a href="{{route('caos.perfil.index')}}" class="dropdown-item listaperfil_btn"  
                                                style="white-space: nowrap;"><i class="fas fa-folder" style="background: transparent; color: red; border: none;"></i> Cadastro de Perfis</a>
                                            </li>                                             
                                            <li class="dropdown-item"><a href="{{route('admin.user.index')}}" class="dropdown-item listaousuarios_btn"  
                                                style="white-space: nowrap;"><i class="fas fa-user" style="background: transparent; color: red; border: none;"></i> Cadastro de Usuários</a>
                                            </li> 
                                </ul>
          </div>
        </div>
      </div>
  @else
  <div class="p-2 mt-2">
<div class="card" style="width: 18rem;">
  <div class="row no-gutters">
    <div class="col-md-4">
      <img src="{{asset('flor-de-cerejeira.png')}}" class="card-img" alt="sistema">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title"><b>{{auth()->user()->name}}</b>,</h5>
        <p class="card-text">Você não tem acesso a esta área.</p>
        <p class="card-text"><small class="text-muted">Grato pela compreensão.</small></p>
      </div>
    </div>
  </div>
</div>
</div>
@endif
</div>
</div>
</div>


@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->
@stop

@section('js')

@stop

