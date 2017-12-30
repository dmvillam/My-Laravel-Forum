@extends('layouts.app')

@section('title')
    {{ $entry->title }} - {{ $entry->blog->name }}
@endsection

@section('head')
    <!-- JS -->
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script> <!-- load angular -->

    <!-- ANGULAR -->
    <!-- all angular resources will be loaded from the /public folder -->
    <script src="{{ url('/') }}/js/controllers/entryRepliesCtrl.js"></script> <!-- load our controller -->
    <script src="{{ url('/') }}/js/services/entryRepliesService.js"></script> <!-- load our service -->
    <script src="{{ url('/') }}/js/blog_comments.js"></script> <!-- load our application -->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <ol class="breadcrumb">
                <li><a href="{{ route('blogs.index') }}"><i class="glyphicon glyphicon-book"></i> Blogs</a></li>
                <li><a href="">Blogs de {{ $entry->user->nickname }}</a></li>
                <li><a href="{{ route('blogs.show', [$entry->blog]) }}">{{ $entry->blog->name }}</a></li>
                <li class="active">{{ $entry->title }}</li>
            </ol>
        </div>
    </div>

    <div class="row" style="margin:5px">
        <div class="col-lg-9">
            {{--
            <div style="height: 250px; overflow: hidden; background: url('http://curso.basico/other/Sin título2.png') center center; background-size: cover; "></div>
            --}}
            <div style="height: 250px; width: 100%; overflow: hidden; position:relative;">
                <img src="{{ $entry->pic_url }}" style="position: absolute; width: 135%; z-index: -1;">
            </div>
            <div style="margin: 0 60px; padding: 20px 35px; margin-top: -50px; background-color: white;">
                <p><a href="" class="btn btn-info">Twittear</a> <a href="" class="btn btn-info">Compartir</a></p>
                <p>
                    <a href="{{ route('users.profile', [$entry->user]) }}">{!! $entry->user->profile->ImgAvatar(40,40) !!}</a>
                    por
                    <a href="{{ route('users.profile', [$entry->user]) }}">{{ $entry->user->nickname }}</a>,
                    <i>publicado el día {{ $weekday }}, {{ $date }} a las {{ $time }}</i>.
                </p>
                <h1>{{ $entry->title }}</h1>
            </div>
            <div style="padding: 20px 35px;">
                <p class="text-justify" style="font-size: 1.2em">{!! $entry->clean_content !!}</p>
                <hr>
                <p>0 comentarios</p>
                <p>
                    <a href="" class="btn btn-info">Compartir en Twitter</a>
                    <a href="" class="btn btn-info">Compartir en Facebook</a>
                    @if ( ! Auth::guest())
                        @if (Auth::user()->id == $entry->user->id)
                            <a href="{{ route('blogs.entry.edit', [$entry->blog, $entry]) }}" class="btn btn-default pull-right">
                                <i class="glyphicon glyphicon-pencil"></i>
                                Editar Entrada
                            </a>
                            <a href="" class="btn btn-default pull-right" data-toggle="modal" data-target="#ModalDeleteEntry">
                                <i class="glyphicon glyphicon-pencil"></i>
                                Borrar Entrada
                            </a>
                        @endif
                    @endif
                </p>
                <p class="pull-right">Etiquetas:
                    @if (count($entry->tags) > 0)
                        @foreach($entry->tags as $tag)
                            <a href="">
                                <span class="badge">{{ $tag->title }}</span>
                            </a>
                        @endforeach
                    @else
                        <i>Ninguna</i>.
                    @endif
                </p>
                <p>-</p>
                <hr>

                <!-- Comentarios-->
                @include('blogs.entry.partials.replies')

            </div>
        </div>

        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">Más de este autor</div>
                <div class="panel-body"></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Entradas relacionadas</div>
                <div class="panel-body"></div>
            </div>
        </div>
    </div>

    {{--
    -- Modals
    --}}
    <div class="modal fade" id="ModalDeleteEntry" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="glyphicon glyphicon-alert"></i> ALERTA:</h4>
                </div>
                <div class="modal-body">
                    <p>
                        Estás apunto de eliminar la entrada.
                        Una vez borrada, no será posible recuperarla, ¿Deseas continuar?
                    </p>
                </div>
                {!! Form::open(['route' => ['blogs.entry.destroy', $entry->blog ,$entry], 'method' => 'DELETE']) !!}
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
    <script>
        constants = {};
        @if ( ! Auth::guest())
        constants.auth_user_id = {{ Auth::user()->id }};
        @else
            constants.auth_user_id = 0;
        @endif
        constants.entry_user_id = {{ $entry->user->id }};
    </script>
@endsection