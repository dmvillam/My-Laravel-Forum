@extends('layouts.app')

@section('title')
    Índice de Foros
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <ol class="breadcrumb">
                <li class="active"><i class="glyphicon glyphicon-home"></i> Índice de Foros</li>
            </ol>

            @if (count($categories) > 0)
                @foreach($categories as $category)
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ $category->name }}</div>
                        <div class="panel-body">
                            @foreach($category->boards as $board)
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-1">
                                                {!! $board->ImgLogo() !!}
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong><a href="{{ route('forum.thread.index', $board) }}">{{ $board->name }}</a></strong></p>
                                                <p>{{ $board->desc }}</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p>
                                                    Hilos: {{ count($board->threads) }}
                                                </p>
                                                <p>
                                                    <?php $posts = 0; ?>
                                                    @foreach($board->threads as $thread)
                                                        <?php $posts += count($thread->posts) ?>
                                                    @endforeach
                                                    Posts: {{ $posts }}
                                                </p>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="row">

                                                    <?php $last_thread = \App\Thread::where('board_id', '=', $board->id)
                                                            ->orderBy('updated_at', 'ASC')->get()->last() ?>

                                                    <div class="col-md-3">
                                                        <p>
                                                            @if (count($board->threads) > 0)
                                                                <a href="{{ route('users.profile', $last_thread->posts->last()->user) }}">
                                                                    {!! $last_thread->posts->last()->user->profile->ImgAvatar(45,45,'img-circle',$last_thread->posts->last()->user->nickname.' fue el último en arruinar este board con sus posts') !!}
                                                                </a>
                                                            @else
                                                                -
                                                            @endif
                                                        </p>
                                                    </div>

                                                    <div class="col-md-9">
                                                        @if (count($board->threads) > 0)
                                                            <p>
                                                                Último:
                                                                <a href="{{ route('forum.post.index', [$board->id, $last_thread->id]) }}" title="{{ $last_thread->title }}">
                                                                    {{ $last_thread->short_title }}
                                                                </a>
                                                            </p>
                                                            <p>
                                                                Por:
                                                                <a href="{{ route('users.profile', $last_thread->posts->last()->user->id) }}">
                                                                    {{ $last_thread->posts->last()->user->nickname }}
                                                                </a>
                                                            </p>
                                                        @else
                                                            <p>-</p>
                                                            <p>-</p>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <div class="panel panel-default">
                    <div class="panel-heading">Foro vacío</div>
                    <div class="panel-body">Aún no han sido creadas secciones para este foro.</div>
                </div>
            @endif
        </div>
    </div>
@endsection