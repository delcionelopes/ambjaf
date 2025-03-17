@extends('layouts.page')
@section('content')

<!-- Cabeçalho-->
<header class="masthead" style="background-image: url('/assets/img/home-bg.jpg')">
            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="site-heading">
                            <h1>Dojo Japonês</h1>
                            <span class="subheading">Cultura e tradição marcial</span>
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
                </div>      
            </div>
</div>
        <!-- Rodapé-->
        <footer class="border-top">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">                        
                        <div class="small text-center text-muted fst-italic">Copyright &copy; Laravel & Ajax – por Delcione Lopes da Silva</div>
                    </div>
                </div>
            </div>
        </footer>      
@endsection
@section('scripts')

@endsection
