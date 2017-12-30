@extends('layouts.app')

@section('title')
    Blogs
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
{{----}}
@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <ol class="breadcrumb">
                <li><a href="{{ route('blogs.index') }}"><i class="glyphicon glyphicon-book"></i> Blogs</a></li>
                <li class="active">Índice</li>
            </ol>
        </div>
    </div>

    <div class="row" style="margin:5px">
        <div class="col-lg-9">
            <div class="panel panel-default">
                <div class="panel-heading">Entradas más leidas del día</div>
                <div class="panel-body">
                    <div class="row">
                        @if (count($entries) > 0)
                            @foreach($entries as $entry)
                                <div class="col-md-4">
                                    <div class="panel panel-default">
                                        <a href="{{ route('blogs.entry.show', [$entry->blog, $entry]) }}">
                                            <div style="position:relative; height: 250px; overflow: hidden; background: #B0BEC5;">
                                                @if($entry->pic == null)
                                                    <?php $img = url('/') . '/logos/default.png' ?>
                                                @else
                                                    <?php $img = url('/') . '/attachments/' . $entry->pic ?>
                                                @endif
                                                <img src="{{ $img }}" style="position: absolute; max-width: 135%;">
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
                                            <p class="pull-right"><i class="glyphicon glyphicon-user"></i> ? visitas</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div style="text-align: center">
                                @if ( ! Auth::guest())
                                    <p>Nadie ha creado ninguna entrada. Sé el primero.</p>
                                    <p>
                                        <a href="{{ route('blogs.create') }}" class="btn btn-default btn-lg" role="button">
                                            <i class="glyphicon glyphicon-book"></i> Abrir mi blog
                                        </a>
                                    </p>
                                @else
                                    <p>Nadie ha creado ninguna entrada.</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Entradas recientes</div>
                <div class="panel-body"></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Blogs nuevos</div>
                <div class="panel-body"></div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">Estadísticas</div>
                <div class="panel-body">
                    <p>{{ count(\App\Blog::all()) }} Blog{{ (count(\App\Blog::all())==1)?'':'s' }}</p>
                    <p>{{ count(\App\Entry::all()) }} Entrada{{ (count(\App\Entry::all())==1)?'':'s' }}</p>
                </div>
            </div>
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
@endsection

@section('scripts')
@endsection
