@extends('layouts.page')
@section('content')

<!-- Cabeçalho-->
<header class="masthead" style="background-image: url('/assets/img/home-bg.jpg')">
            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="site-heading">
                            <h1>{{$tema->titulo}}</h1>
          <span class="subheading">{{$tema->artigos->count()}} artigo(s) relacionado(s)</span>
                        </div>
                    </div>
                </div>
            </div>
</header>
<div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
 
                    <!-- Artigos preview-->
                    @forelse($artigos as $artigo)
                    <div class="post-preview">
                        <a href="{{route('page.detail',['slug' => $artigo->slug])}}">
                            <h2 class="post-title">{{$artigo->titulo}}</h2>
                            <h3 class="post-subtitle">{{$artigo->descricao}}</h3>
                        </a>
                        <p class="post-meta">
                            Postado por
                            <a href="#!">{{$artigo->users->name}}</a>                            
                            {{ucwords(strftime('%A, %d de %B de %Y', strtotime($artigo->created_at)))}}
                            <a href="{{route('page.detail',['slug' => $artigo->slug])}}">
                                <i class="fas fa-comment"></i> {{$artigo->comentarios()->count()}}
                            </a>                             
                        </p>
                    </div>
                    @empty
                    <div class="alert alert-warning">Não encontramos artigo(s) para este tema!</div>
                    <!-- Divisor-->
                    <hr class="my-4" />                   
                    @endforelse
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
