@extends('adminlte::page')

@section('title', 'Secundária')

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

@foreach ($operacoes as $ope)   
  @foreach($autorizacao as $aut)
  @if(($aut->modope_operacao_id) == ($ope->id))
    <div class="p-2 mt-2">
    <div class="card card-hover" style="width: 14rem;">
      <div class="card-header">
        <b style="background: transparent; color: black; border: none;"><i class="fas fa-desktop"></i> {{$ope->nome}}</b>
      </div>
      <a href="" data-id="{{$ope->id}}" id="link" class="abrir">
      <img class="card-img-top" src="{{asset('storage/'.$ope->ico)}}" alt="Imagem de capa do módulo" width="286" height="180">
      </a>
      <div class="card-body">                
        <p class="card-text">{{$ope->descricao}}</p>        
        <button type="button" id="abrir_btn" data-id="{{$ope->id}}" class="abrir btn btn-{{$aut->modulo->color}}">Abrir</button>
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

<script type="text/javascript">

$(document).ready(function(){

  $(document).on('click','.abrir',function(e){
    e.preventDefault();
    var codoperacao = $(this).data("id");

    switch (codoperacao) {
      case 1: location.replace('/admin/artigos/index'); ///frontpage/postagens
      break;
      case 2: location.replace('/admin/tema/index'); //frontpage/temas        
      break;      
    
      default:
        break;
    }

  });

});

</script>

@stop

