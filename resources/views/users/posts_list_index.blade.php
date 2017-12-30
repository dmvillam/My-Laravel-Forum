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
                        <p><h3>Posts publicados por {{ $user->nickname }}</h3></p>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                @if (count($user->posts) > 0)
                    {!! $posts->render() !!}
                    @foreach($posts as $post)
                        <a href="{{ route('forum.post.index', [$post->thread['board'], $post->thread]) }}" class="list-group-item">
                            <h4 class="list-group-item-heading">Foro > {{ $post->thread['board']['category']['name'] }} > Tema: {{ $post->thread['title'] }}</h4>
                            <div class="list-group">
                                <p class="list-group-item-text">
                                    {{ $post->content }}
                                </p>
                            </div>
                            <p class="list-group-item-text">
                                <strong>Publicado en:</strong> {{ date('M d, Y', strtotime($post->created_at)) }}
                            </p>
                        </a>
                    @endforeach
                    {!! $posts->render() !!}
                @else
                    Este usuario no ha publicado ningún post.
                @endif
            </div>
        </div>
    </div>
@endsection