@extends('adminlte::page')

@section('title', 'Principal')

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

            <header class="card p-3" style="background-image: url('/assets/img/banner-docs.jpg')">
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
            </header>         
<div class="container-fluid">
<div class="row">

@if($autorizacao->count())

@foreach ($modulos as $mod)   
  @foreach($autorizacao as $aut)
  @if(($aut->modulo_codmod) == ($mod->codmod))
    <div class="p-2 mt-2">
    <div class="card card-hover" style="width: 14rem;">
      <div class="card-header">
        <b style="background: transparent; color: black; border: none;"><i class="fas fa-desktop"></i> {{$mod->nome}}</b>
      </div>
      <img class="card-img-top" src="{{asset('storage/'.$mod->imagem)}}" alt="Imagem de capa do módulo" width="286" height="180">
      <div class="card-body">                
        <p class="card-text">{{$mod->descricao}}</p>        
        <a href="{{route('caos.principal.operacoes',['id' => $mod->codmod])}}" type="button" class="btn btn-{{$mod->cor}}">Opções</a>
      </div>
    </div>
  </div>
  @break
  @elseif ($loop->last)
  {{-- cessa a construção de cards --}}
  @endif
  @endforeach
@endforeach
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
</div>


@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">  -->    
@stop

@section('js')

@stop

