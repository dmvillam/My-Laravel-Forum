@extends('layouts.app')

@section('title')
    Blog: {{ $blog->name }}
@endsection

@section('styles')
    <style>
        .article-preview {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: linear-gradient(transparent, white);
            height:80px;
        }

        .blog-preview {
            position: relative;
            height: 80px;
            overflow: hidden;
            z-index: 0;
            margin-bottom: 10px;
        }
        .blog-preview::after {
            content: '';
            position: absolute;
            top: 0;
            height: 80px;
            background: linear-gradient(rgba(0,0,0,0), rgba(0,0,0,0.5));
            width: 100%;
            z-index: 0;
        }
        .blog-preview-text {
            padding: 0 8px;
            height: 80px;
            position: absolute;
            top: 0;
            color: white;
            text-shadow: 1px 1px 1px #111, 0px 0px 10px rgba(0,0,0,0.7);
            z-index: 1;
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <ol class="breadcrumb">
                <li><a href="{{ route('blogs.index') }}"><i class="glyphicon glyphicon-book"></i> Blogs</a></li>
                <li><a href="">Blogs de {{ $blog->user->nickname }}</a></li>
                <li class="active">{{ $blog->name }}</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div style="position:relative; height: 220px; overflow: hidden; background: #242628; color: white;">
                <img src="{{ $blog->banner_url }}" style="width: 100%; position: absolute; top: -40px;">
                <div style="position: absolute; height: 120px; width: 100%; z-index: 0; background: linear-gradient(rgba(0,0,0,0), rgba(0,0,0,0.5)); top: 100px;"></div>
                <div style="position: absolute; padding: 0px 20px; bottom: -10px;">
                    <h1 style="text-shadow: 0px 0px 5px black;"><strong>{{ $blog->name }}</strong></h1>
                    <p>{{ $blog->desc }}</p>
                    <p><a href="{{ route('users.profile', [$blog->user]) }}">{!! $blog->user->profile->ImgAvatar(40,40) !!}</a> Autor: {{ $blog->user->nickname }}</p>
                </div>
                @if ( ! Auth::guest())
                    @if (Auth::user()->id == $blog->user->id)
                        <div style="position: absolute; right: 0px; margin: 20px;">
                            <a href="" class="btn btn-default" role="button" style="background: rgba(0,0,0,0.5); color: white;"><i class="glyphicon glyphicon-picture"></i> <i class="caret"></i></a>
                        </div>
                    @endif
                @endif
            </div>
            <div style="position:relative; height: 80px; background: #242628; color: white; padding: 10px;">
                <div style="position: absolute; left: 20px;">
                    <p><i class="glyphicon glyphicon-list-alt"></i> Entradas:</p>
                    <p>{{ count($blog->entries) }}</p>
                </div>
                <div style="position: absolute; left: 120px;">
                    <p><i class="glyphicon glyphicon-comment"></i> Comentarios:</p>
                    <p>{{ $replies_count }}</p>
                </div>
                <div style="position: absolute; left: 240px;">
                    <p><i class="glyphicon glyphicon-user"></i> Visitas:</p>
                    <p>?</p>
                </div>
                <div style="position: absolute; right: 20px; top: 20px;">
                    <button type="button" class="btn btn-success">
                        Seguir
                        <div style="display: inline; background: white; color: black; padding: 4px 12px; margin-left: 8px; border-radius: 4px;">0</div>
                    </button>
                </div>
            </div>
            {{--
            <div style="background: #242628; color: white; padding: 10px;">
                <div class="row">
                    <div class="col-md-2">
                        <p><i class="glyphicon glyphicon-list-alt"></i> Entradas:</p>
                        <p>{{ count($blog->entries) }}</p>
                    </div>
                    <div class="col-md-2">
                        <p><i class="glyphicon glyphicon-comment"></i> Comentarios:</p>
                        <p>375325</p>
                    </div>
                    <div class="col-md-2">
                        <p><i class="glyphicon glyphicon-user"></i> Visitas:</p>
                        <p>46823734878</p>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-success pull-right">
                            Seguir
                            <div style="display: inline; background: white; color: black; padding: 4px 12px; margin-left: 8px; border-radius: 4px;">0</div>
                        </button>
                    </div>
                </div>
            </div>
            --}}

        </div>
    </div>

    <div class="row" style="margin:5px">
        <div class="col-lg-9">
            @if ( ! Auth::guest())
                @if (Auth::user()->id == $blog->user->id)
                    <div style="margin: 10px;">
                        <a href="{{ route('blogs.entry.create', [$blog]) }}" class="btn btn-default" role="button">
                            <i class="glyphicon glyphicon-plus"></i>
                            Crear nueva entrada
                        </a>
                        <a href="{{ route('blogs.edit', [$blog]) }}" class="btn btn-default" role="button">
                            <i class="glyphicon glyphicon-pencil"></i>
                            Editar Blog
                        </a>
                        <a href="" class="btn btn-default" role="button" data-toggle="modal" data-target="#ModalDeleteBlog">
                            <i class="glyphicon glyphicon-remove"></i>
                            Eliminar blog
                        </a>
                    </div>
                @endif
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">Entradas</div>
                <div class="panel-body">
                    <div class="row">
                        @if (count($blog->entries) > 0)
                            @foreach($blog->entries as $entry)
                                <div class="col-md-4">
                                    <div class="panel panel-default">
                                        <a href="{{ route('blogs.entry.show', [$blog, $entry]) }}">
                                            <div style="position:relative; height: 250px; overflow: hidden; background: #B0BEC5;">
                                                <img src="{{ $entry->pic_url }}" style="position: absolute; max-width: 135%;">
                                                <div class="container" style="z-index: 1; position: absolute; width: 100%; bottom: 16px; color: white; text-shadow: 0px 0px 5px black;">
                                                    <h3>{{ $entry->title }}</h3>
                                                    <div class="pull-right">
                                                        <i>
                                                            <div>Publicado el día: {{ $entry->created_at->format('d/m/Y') }}</div>
                                                            <div class="pull-right">{{ $entry->created_at->diffForHumans() }}</div>
                                                        </i>
                                                    </div>
                                                </div>
                                                <div style="position: absolute; height: 100px; width: 100%; z-index: 0; background: linear-gradient(rgba(0,0,0,0), rgba(0,0,0,0.5)); top: 150px;"></div>
                                            </div>
                                        </a>
                                        <div class="panel-body">
                                            <p>{!! $entry->user->profile->ImgAvatar(35,35) !!} por {{ $entry->user->nickname }} | <i class="glyphicon glyphicon-comment"></i> {{ count($entry->replies) }} comentario{{ (count($entry->replies) == 1)?'':'s' }}</p>
                                            <div style="position: relative">
                                                {!! $entry->fragmented_content !!}
                                                <div class="article-preview"></div>
                                            </div>
                                            <div class="pull-right"><i class="glyphicon glyphicon-user"></i> ? visitas</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div style="text-align: center">
                                <p>Aún no haz publicado ningúna entrada.</p>
                                <p>
                                    <a href="{{ route('blogs.entry.create', [$blog]) }}" class="btn btn-default btn-lg" role="button">
                                        <i class="glyphicon glyphicon-book"></i> Crear mi primer artículo
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            @if ( ! Auth::guest())
                <div class="panel panel-default">
                    <div class="panel-heading">Administrar mis blogs</div>
                    <div class="panel-body">
                        @if(count(Auth::user()->blogs) > 0)
                            @foreach(Auth::user()->blogs as $blog)
                                <a href="{{ route('blogs.show', $blog) }}">
                                    <div class="blog-preview">
                                        @if ($blog->banner_url != null)
                                            <img src="{{ $blog->banner_url }}" style="width: 100%; position: absolute; top: -40px;">
                                        @else
                                            <div style="height: 80px; background: darkgray;"></div>
                                        @endif
                                        <div class="blog-preview-text">
                                            <h4><strong>{{ $blog->name }}</strong></h4>
                                            <div>{{ $blog->desc }}</div>
                                            <div class="pull-right" style="font-size: 0.9em; font-style: italic">
                                                <i class="glyphicon glyphicon-list-alt"></i>
                                                {{ count($blog->entries) }} entrada{{ (count($blog->entries)==1)?'':'s' }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div>No tienes ningún blog</div>
                        @endif
                        <div>
                            <a href="{{ route('blogs.create') }}" class="btn btn-default pull-left" role="button">
                                <i class="glyphicon glyphicon-book"></i> Crear nuevo blog
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{--
    -- Modals
    --}}
    <div class="modal fade" id="ModalDeleteBlog" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="glyphicon glyphicon-alert"></i> ALERTA:</h4>
                </div>
                <div class="modal-body">
                    <p>
                        Estás apunto de eliminar el blog, junto con todas sus entradas.
                        Una vez borrado, no será posible recuperarlo, ¿Deseas continuar?
                    </p>
                </div>
                {!! Form::open(['route' => ['blogs.destroy', $blog], 'method' => 'DELETE']) !!}
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="glyphicon glyphicon-alert"></i>
                        Confirmar
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
