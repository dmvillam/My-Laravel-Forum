@extends('layouts.app')

@section('title')
    {{ $thread->title }} - {{ $thread->board->name }}
@endsection

@section('styles')
    <style>
        .tags {
            background: #23374a;
            padding: 0px 8px;
            color: white;
            margin-left: 10px;
            font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
            font-size: 0.8em;
            border-radius: 0 2px  2px 0;
        }
        .tags::before {
            content: "";
            border-top: 8px solid transparent;
            border-right: 8px solid #23374a;
            border-bottom: 9px solid transparent;
            width: 0;
            height: 0;
            position: absolute;
            margin-top: 2px;
            margin-bottom: 0;
            margin-left: -16px;
            margin-right: 0;
        }
    </style>
@endsection

@section('content')
    <div class="col-md-10 col-md-offset-1">

        <!-- Navegación -->
        @include('forum.post.partials.navigation')

        <div class="panel">
            <h2>
                @if ($thread->locked == 1)
                    <i class="glyphicon glyphicon-lock"></i>
                @endif
                {{ $thread->title }}
            </h2>
            <p>Autor: {{ $thread->posts->first()->user->nickname }}</p>
            <p style="font-size: 0.9em">
                Etiquetas:
                @if (count($thread->tags) > 0)
                    @foreach($thread->tags as $tag)
                        <a href=""><span class="tags">{{ $tag->title }}</span></a>
                    @endforeach
                @else
                    <i>Ninguna</i>.
                @endif
            </p>
            @if ($thread->locked == 1)
                <p style="color: red"><strong><i>Este hilo se encuentra cerrado.</i></strong></p>
            @endif
        </div>

        {!! $posts->render() !!}

        @if ( ! Auth::guest())
            @if (! $thread->locked || Auth::user()->IsAdmin())
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <p>
                            <ul class="nav nav-pills" role="tablist">
                                @if(Auth::user()->IsAdmin())
                                    <li role="presentation" class="dropdown">
                                        <a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            Moderación <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="drop4">
                                            <li><a href="#" id="thread-lock" data-lock="{{ $thread->locked }}"><i class="glyphicon glyphicon-lock"></i> {{ ($thread->locked == 0) ? 'Cerrar hilo' : 'Abrir hilo' }}</a></li>
                                            <li><a href="#" id="thread-stick" data-stick="{{ $thread->sticky }}"><i class="glyphicon glyphicon-flag"></i> {{ ($thread->sticky == 0) ? 'Subir hilo a Importantes' : 'Retirar hilo de Importantes' }}</a></li>
                                            <li><a href="#" id="thread-move" data-toggle="modal" data-target="#ModalMoveThread"><i class="glyphicon glyphicon-arrow-right"></i> Mover hilo a otro board</a></li>
                                            <li><a href="#" id="thread-delete" data-ttitle="{{ $thread->title }}" data-toggle="modal" data-target="#ModalDeleteThread"><i class="glyphicon glyphicon-trash"></i> Eliminar hilo</a></li>
                                        </ul>
                                    </li>
                                @endif
                                <li role="presentation" class="active">
                                    <a href="{{ route('forum.post.create', [$thread->board->id, $thread->id]) }}" role="button">
                                        <i class="glyphicon glyphicon-plus"></i> Responder
                                    </a>
                                </li>
                            </ul>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        @foreach($posts as $post)

            <div class="panel panel-default post">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-2">
                            <a href="{{ route('users.profile', $post->user) }}">
                                {{ $post->user->nickname }}
                            </a>
                        </div>
                        <div class="col-md-10">{{ $post->title }} / <a>Enlace al post</a></div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <p>
                                @if ($post->user->profile->avatar != null)
                                    {!! $post->user->profile->ImgAvatar(150,150,'img-circle','Avatar de ' . $post->user->nickname) !!}
                                @endif
                            </p>
                            <p>{{ config('options.types')[$post->user->type] }}</p>
                            <p>Hilos: {{ count($post->user->threads) }}</p>
                            <p>Posts: {{ count($post->user->posts) }}</p>
                            <p>{{ $post->user->profile->website }}</p>
                            <p>{{ $post->user->profile->twitter }}</p>
                            <p>País: {{ $post->user->profile->country }}</p>
                        </div>
                        <div class="col-md-10">
                            {{--<p>{!! $post->clean_content !!}</p>--}}
                            <p>{!! $post->content !!}</p>
                            @if ( ! Auth::guest() && ! $thread->locked)
                                @if (Auth::user()->IsAdmin() || Auth::user()->nickname == $post->user->nickname)
                                    <p>
                                        {!! Form::open(['route' => ['forum.post.delete', $thread->board, $thread, $post], 'method' => 'DELETE', 'style' => 'float:right']) !!}
                                        <a href="{{ route('forum.post.edit', [$thread->board, $thread, $post]) }}" role="button" class="btn btn-success">
                                            <i class="glyphicon glyphicon-pencil"></i> Editar
                                        </a>
                                        <button type="submit" class="btn btn-warning" onclick="return confirm('¿Seguro que desea eliminar?')">
                                            <i class="glyphicon glyphicon-remove"></i> Borrar
                                        </button>
                                        {!! Form::close() !!}
                                    </p>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @endforeach

                    <!-- Botón de pls rspnd -->
                @if ( ! Auth::guest())
                    @if (! $thread->locked || Auth::user()->IsAdmin())
                    <p>
                        <a class="btn btn-info" href="{{ route('forum.post.create', [$thread->board->id, $thread->id]) }}" role="button">
                            <i class="glyphicon glyphicon-plus"></i> Responder
                        </a>
                    </p>
                    @endif
                @endif

                    {!! $posts->render() !!}

                        <!-- Navegación -->
            @include('forum.post.partials.navigation')

            @if ( ! Auth::guest() )
                @if (! $thread->locked || Auth::user()->IsAdmin())
                    <!-- Formulario de quick pls rspnd -->
                <div id="quick-reply" class="panel panel-default">
                    <div class="panel-heading">
                        Respuesta rápida (Powered by AJAX)
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-1">
                                <a href="{{ route('users.profile', Auth::user()) }}">
                                    {!! Auth::user()->profile->ImgAvatar(50,50,'img-circle','Postear como: '.Auth::user()->nickname) !!}
                                </a>
                            </div>
                            <div class="col-md-11">
                                {!! Form::open(['route' => ['forum.post.store', $thread->board, $thread], 'method' => 'POST']) !!}
                                {!! Form::hidden('title', 'Re: ' . $thread->title) !!}
                                @if (Auth::user()->IsAdmin())
                                    <div class="form-group">
                                        {!! Form::label('alt-user', 'Postear como otro usuario') !!}
                                        {!! Form::text('alt-user', null, ['class' => 'form-control', 'placeholder' => 'Inserte nickname de otro usuario']) !!}
                                    </div>
                                @endif
                                {{--<div class="form-group">
                                    {!! Form::label('content', 'Mensaje') !!}
                                    {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Escriba su mensaje']) !!}
                                </div>--}}
                                <div class="form-group">
                                    <div id="content" role="textbox" contenteditable="true"></div>
                                </div>
                                <div class="form-group"></div>
                                <button type="submit" class="btn btn-info" id="quickreply">Publicar</button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endif
    </div>

    {!! Form::open(['route' => ['forum.thread.update', $thread->board, $thread], 'method' => 'PUT', 'id' => 'form-edit-thread']) !!}
    {!! Form::close() !!}

    <!--
      -- Modals
      -->
    {!! Form::open(['route' => ['forum.thread.update', $thread->board, $thread], 'method' => 'PUT', 'id' => 'form-edit-thread']) !!}
    {!! Form::hidden('action', 'move-thread') !!}
    <div class="modal fade" id="ModalMoveThread" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Mover hilo:</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2">
                            <p>{!! Form::label('dest-board', 'Mover a: ') !!}</p>
                        </div>
                        <div class="col-md-10">
                            <p>{!! Form::select('dest-board', $move_board_array, null, ['class' => 'form-control', 'required' => 'required']) !!}</p>
                        </div>
                    </div>
                    <p>
                        {!! Form::checkbox('move-thread-flag', 'true', true) !!}
                        {!! Form::label('move-thread-flag', 'Dejar un hilo de redirección en la board original.') !!}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    {!! Form::open(['route' => ['forum.thread.delete', $thread->board, $thread], 'method' => 'DELETE', 'id' => 'form-board-delete']) !!}
    <div class="modal fade" id="ModalDeleteThread" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminar Topic:</h4>
                </div>
                <div class="modal-body">
                    <p><strong>Advertencia:</strong> si eliminas el tópico también serán eliminados todos los posts contenidos en éste.</p>
                    <p>¿Estás seguro que deseas continuar?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btn-delete-board" class="btn btn-danger">
                        Confirmar
                    </button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script src="{{ url('/') . '/js/forum_post_index_ajax.js' }}"></script>
    <script>
        $(document).ready(function () {
            $('#thread-lock,#thread-stick,#thread-delete').click(function (e) {
                e.preventDefault();
            });

            $('#thread-lock').click(function () {
                form = $('#form-edit-thread');
                form.append(
                        $('<input type="hidden" name="locked" value="' + $(this).data('lock') + '">')
                ).append(
                        $('<input type="hidden" name="action" value="lock-thread">')
                ).submit();
            });

            $('#thread-stick').click(function () {
                form = $('#form-edit-thread');
                form.append(
                        $('<input type="hidden" name="sticky" value="' + $(this).data('stick') + '">')
                ).append(
                        $('<input type="hidden" name="action" value="stick-thread">')
                ).submit();
            });

            $('#ModalDeleteThread').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var thread_name = button.data('ttitle');
                $('#ModalDeleteThread').find('.modal-title').text('Eliminar Topic: ' + thread_name);
            });
        });
    </script>

    <script type="text/javascript" src='//cdn.tinymce.com/4/tinymce.min.js'></script>

    <script type="text/javascript">
        tinymce.init({
            selector: 'div#content'
            /*,
             theme: 'modern',
             plugins: [
             'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
             'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
             'save table contextmenu directionality emoticons template paste textcolor'
             ],
             content_css: 'css/content.css',
             toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons'
             */
        });
    </script>
@endsection