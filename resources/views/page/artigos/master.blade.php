@extends('layouts.page')
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

<!-- Cabeçalho-->
<header class="masthead" style="background-image: url('/assets/img/home-bg.jpg')">
            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="site-heading">
                            <h1>Associação de Moradores</h1>
                            <span class="subheading">Bairro Jardim Floresta</span>
                        </div>
                    </div>
                </div>
            </div>
</header>
<div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                <!--pesquisa -->
                <form action="{{route('page.master')}}" class="form-search" method="GET">
                    <div class="input-group">                    
                        <input class="form-control rounded-pill py-2 pr-5 mr-1 bg-transparent" tabindex="1" type="search" name="pesquisa" autocomplete="off">                                                
<div class="input-group-text border-0 bg-transparent ml-n5"><i class="fas fa-search"></i> </div>                        
                    </div>                     
                </form>
                <!--barra de informações-->
                <nav class="navbar navbar-expand-lg navbar-default bg-default justify-content-left">        
                <ul class="menu">                    
                    <li><a href="#!">Temas</a>
                        <ul>
                  @foreach($temas as $tema)
                  <li><a href="{{route('page.tema',['slug' => $tema->slug])}}">{{$tema->titulo}}</a></li>
                   @endforeach      	                  
                        </ul>
                    </li>                           
                </ul>
                </nav>  
                    <!-- Artigos preview -->
                    @foreach($artigos as $artigo)
                    <div class="post-preview">
                        <a href="{{route('page.detail',['slug' => $artigo->slug])}}">
                            <h2 class="post-title">{{$artigo->titulo}}</h2>
                            <h3 class="post-subtitle">{{$artigo->descricao}}</h3>
                        </a>
                        <p class="post-meta">
                            Postado por
                            @if($artigo->user)
                            <a href="#!">{{$artigo->user->name}}</a>                            
                            @endif
                            {{ucwords(strftime('%A, %d de %B de %Y', strtotime($artigo->created_at)))}}
                            <a href="{{route('page.detail',['slug' => $artigo->slug])}}">
                                <i class="fas fa-comment-alt"></i> {{$artigo->comentarios()->count()}}
                            </a>                             
                        </p>
                    </div>
                    <!-- Linha divisória-->
                    <hr class="my-4" />                   
                    @endforeach
                    <!-- Paginação-->
                    <div class="d-flex hover justify-content-center">
                    {{$artigos->links()}}
                    </div>
                    <!-- Patrocínios -->    
                <div class="container-fluid">
                    <div class="row">
                    <div class="card-group">
                    @if($entidade->patrocinios()->count())   
                    @foreach($patrocinios as $patroc)
                     @foreach($entidade->patrocinios as $patrocinio)
                     @if(($patrocinio->id)==($patroc->id))
                    <div class="p-2 mt-2">       
                    <div class="card card-hover" style="width: 14rem;">                          
                          <a href="{{$patrocinio->link_site}}">
                               <img class="card-img-top" src="{{asset('storage/'.$patrocinio->logo)}}" alt="{{$patrocinio->nome}}" width="286" height="180">
                           </a>
                     </div>
                   </div>
                    @break
                    @elseif ($loop->last)
                    {{-- cessa a construção de cards --}}
                    @endif
                    @endforeach
                    @endforeach                    
                    @else
                    <div class="container-fluid">
                    <div class="row">
                    <div class="p-2 mt-2">
                       <div class="card" style="width: 18rem;">
                           <div class="row no-gutters">
                              <div class="col-md-4">
                                  <img src="{{asset('logo.jpg')}}" class="card-img" alt="sistema">
                              </div>
                       <div class="col-md-8">
                            <div class="card-body">
                                 <h5 class="card-title"><b>Seja bem vindo!</b></h5>
                                 <p class="card-text">Anuncie aqui!</p>
                                 <p class="card-text"><small class="text-muted">Conheça o nosso trabalho!</small></p>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    @endif
                    </div>
                    </div>
                    </div>
                <!-- fim patrocínios -->
                </div>                  
            </div>
</div>
        <!-- Rodapé-->
        <footer class="border-top">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">                        
                        <div class="small text-center text-muted fst-italic">Copyright &copy; AMBJAF - Associação de Moradores do Bairro Jardim Floresta – desenvolvido por Delcione Lopes da Silva</div>
                    </div>
                </div>
            </div>
        </footer>      
@endsection
@section('scripts')

@endsection
