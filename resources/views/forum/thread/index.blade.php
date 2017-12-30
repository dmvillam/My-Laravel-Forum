@extends('layouts.app')

@section('title')
    {{ $board->name }}
@endsection

@section('content')
    <div class="col-md-10 col-md-offset-1">

        <!-- Navegación -->
        @include('forum.thread.partials.navigation')

        <h2>{{ $board->name }}</h2>

        <!-- Botón de Crear Nuevo Hilo -->
        @if ( ! Auth::guest())
            <p>
                <a class="btn btn-info" href="{{ route('forum.thread.create', $board->id) }}" role="button">
                    <i class="glyphicon glyphicon-plus"></i> Crear nuevo hilo
                </a>
            </p>
        @endif

        {!! $threads->render() !!}

        @if (count($board->threads()->where('sticky', '=', 1)->get()) > 0)
            <div class="panel panel-default">
                <div class="panel-heading">Importantes</div>
                <div class="panel-body">

                    @foreach($board->threads()->where('sticky', '=', 1)->orderBy('updated_at', 'DESC')->get() as $thread)
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div style="display: table-cell; padding-right: 4px;">
                                                    <a href="{{ route('users.profile', $thread->posts->first()->user) }}">
                                                        {!! $thread->posts->first()->user->profile->ImgAvatar(45,45,'img-circle', $thread->posts->first()->user->nickname . ' es el iniciador del hilo') !!}
                                                    </a>
                                                </div>
                                                <div style="display: table-cell; vertical-align: middle;">
                                                    <div>
                                                        <strong>Importante: </strong> <a href="{{ route('forum.post.index', [$board->id ,$thread->id]) }}">{{ $thread->title }}</a>
                                                        @include('forum.thread.partials.threadpagination')
                                                    </div>
                                                    <div>
                                                        (Creado por:
                                                        <a href="{{ route('users.profile', $thread->posts->first()->user->id) }}">
                                                            {{ $thread->posts->first()->user->nickname }}
                                                        </a>)
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="pull-right">
                                                    @if ($thread->locked==1)
                                                        <i class="glyphicon glyphicon-lock"></i>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div>Posts: {{ count($thread->posts) }}</div>
                                        <div>Visitas: ?</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div style="display: table-cell; padding-right: 4px;">
                                            <a href="{{ route('users.profile', $thread->posts->last()->user) }}">
                                                {!! $thread->posts->last()->user->profile->ImgAvatar(45,45,'img-circle',$thread->posts->last()->user->nickname.' fue el último en participar en este hilo') !!}
                                            </a>
                                        </div>
                                        <div style="display: table-cell; vertical-align: middle;">
                                            <div>Última respuesta por:</div>
                                            <div>
                                                <a href="{{ route('users.profile', $thread->posts->last()->user->id) }}">
                                                    {{ $thread->posts->last()->user->nickname }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        @endif

        <div class="panel panel-default">
            <div class="panel-heading">Hilos regulares</div>
            <div class="panel-body">

                @if (count($board->threads()->where('sticky', '=', 0)->get()) > 0)
                    @foreach($board->threads()->where('sticky', '=', 0)->orderBy('updated_at', 'DESC')->get() as $thread)
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div style="display: table-cell; padding-right: 4px;">
                                                    <a href="{{ route('users.profile', $thread->posts->first()->user) }}">
                                                        {!! $thread->posts->first()->user->profile->ImgAvatar(45,45,'img-circle', $thread->posts->first()->user->nickname . ' es el iniciador del hilo') !!}
                                                    </a>
                                                </div>
                                                <div style="display: table-cell; vertical-align: middle;">
                                                    <div>
                                                        @if ($thread->locked == 1)
                                                            <a href="{{ route('forum.post.index', [$board->id ,$thread->id]) }}"><i class="glyphicon glyphicon-lock"></i> <strike>{{ $thread->title }}</strike></a>
                                                        @else
                                                            <a href="{{ route('forum.post.index', [$board->id ,$thread->id]) }}">{{ $thread->title }}</a>
                                                        @endif
                                                        @include('forum.thread.partials.threadpagination')
                                                    </div>
                                                    <div>
                                                        (Creado por:
                                                        <a href="{{ route('users.profile', $thread->posts->first()->user->id) }}">
                                                            {{ $thread->posts->first()->user->nickname }}
                                                        </a>)
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div>Posts: {{ count($thread->posts) }}</div>
                                        <div>Visitas: ?</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div style="display: table-cell; padding-right: 4px;">
                                            <a href="{{ route('users.profile', $thread->posts->last()->user) }}">
                                                {!! $thread->posts->last()->user->profile->ImgAvatar(45,45,'img-circle',$thread->posts->last()->user->nickname.' fue el último en participar en este hilo') !!}
                                            </a>
                                        </div>
                                        <div style="display: table-cell; vertical-align: middle;">
                                            <div>Última respuesta por:</div>
                                            <div>
                                                <a href="{{ route('users.profile', $thread->posts->last()->user->id) }}">
                                                    {{ $thread->posts->last()->user->nickname }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else

                    <div style="text-align: center">
                        @if ( ! Auth::guest())
                        <p>Aún no han sido creados hilos para este board. Sé el primero.</p>
                        <p>
                            <a href="{{ route('forum.thread.create', $board->id) }}" class="btn btn-default btn-lg" role="button">
                                <i class="glyphicon glyphicon-plus"></i> Crear nuevo hilo
                            </a>
                        </p>
                        @else
                            <p>Aún no han sido creados hilos para este board.</p>
                        @endif
                    </div>

                @endif

            </div>
        </div>

        <!-- Navegación -->
        @include('forum.thread.partials.navigation')

    </div>
@endsection