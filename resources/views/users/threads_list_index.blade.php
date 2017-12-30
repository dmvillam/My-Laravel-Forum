@extends('layouts.app')

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default post">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-1">
                        <a href="{{ route('users.profile', $user) }}">
                            {!! $user->profile->ImgAvatar(60,60) !!}
                        </a>
                    </div>
                    <div class="col-md-11">
                        <p><h3>Hilos creados por {{ $user->nickname }}</h3></p>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                @if (count($user->threads) > 0)
                    {!! $threads->render() !!}
                    @foreach($threads as $thread)
                        <div class="list-group">
                            <a href="{{ route('forum.post.index', [$thread->board, $thread]) }}" class="list-group-item">
                                <p>Publicado en board: {{ $thread->board->name }}</p>
                                <h4 class="list-group-item-heading">{{ $thread->title }}</h4>
                                <p class="list-group-item-text">
                                    <strong>Fecha de creación:</strong> {{ date('M d, Y', strtotime($thread->created_at)) }} - <strong>Respuestas:</strong> {{ count($thread->posts) }} - <strong>Última respuesta:</strong> {{ $thread->posts->last()->user->nickname }}
                                </p>
                            </a>
                        </div>
                    @endforeach
                    {!! $threads->render() !!}
                @else
                    Este usuario no ha iniciado ningún hilo.
                @endif
            </div>
        </div>
    </div>
@endsection