@extends('layouts.app')

@section('title')
    Editando post de: "{{ $post->thread->title }}"
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Modificar respuesta de {{ $post->user->nickname }} en hilo: {{ $post->thread->title }}</div>
                    <div class="panel-body">

                        @include('admin.users.partials.messages')

                        {!! Form::model($post, ['route' => ['forum.post.update', $post->thread->board, $post->thread, $post], 'method' => 'PUT']) !!}
                        <div class="form-group">
                            {!! Form::label('title', 'Título') !!}
                            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Cambiar título del post']) !!}
                        </div>
                        @if ($post->reply_id == 0)
                            <div class="form-group">
                                {!! Form::label('tags', 'Etiquetas:') !!}
                                {!! Form::text('tags', null, ['class' => 'form-control', 'placeholder' => 'Escriba las etiquetas separadas por comas.']) !!}
                            </div>
                        @endif
                        @if (Auth::user()->IsAdmin())
                            <div class="form-group">
                                {!! Form::label('alt-user', 'Postear como otro usuario') !!}
                                {!! Form::text('alt-user', null, ['class' => 'form-control', 'placeholder' => 'Inserte nickname de otro usuario']) !!}
                            </div>
                        @endif
                        {{--<div class="form-group">
                            {!! Form::label('content', 'Contenido') !!}
                            {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Nombre del hilo']) !!}
                        </div>--}}
                        <div class="form-group">
                            {!! Form::hidden('hidd_content', $post->content) !!}
                            <div id="content" role="textbox" contenteditable="true" style="width: 100%"></div>
                        </div>
                        <hr>
                        <div class="form-group">
                            {!! Form::checkbox('noko', 'true', true) !!}
                            {!! Form::label('noko', 'Quedarse en el hilo despues de publicar.') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::checkbox('sticky', '1', ($post->thread->sticky==1)?true:false) !!}
                            {!! Form::label('sticky', 'Subir hilo a Importantes.') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::checkbox('locked', '1', ($post->thread->locked==1)?true:false) !!}
                            {!! Form::label('locked', 'Cerrar hilo.') !!}
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-default">
                            <i class="glyphicon glyphicon-pencil"></i> Editar
                        </button>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src='//cdn.tinymce.com/4/tinymce.min.js'></script>

    <script type="text/javascript">
        tinymce.init({
            selector: 'div#content',
            init_instance_callback: "insert_contents",
        });

        function insert_contents(inst) {
            inst.setContent($('input[name=hidd_content]').val());
        }
    </script>
@endsection