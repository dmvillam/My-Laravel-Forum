@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Nueva respuesta</div>
                    <div class="panel-body">

                        @include('admin.users.partials.messages')

                        {!! Form::model($thread, ['route' => ['forum.post.store', $thread->board, $thread], 'method' => 'POST']) !!}
                        <div class="form-group">
                            {!! Form::label('title', 'Título') !!}
                            {!! Form::text('title', 'Re: ' . $thread->title, ['class' => 'form-control', 'placeholder' => 'Cambiar título del post']) !!}
                        </div>
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
                            <div id="content" role="textbox" contenteditable="true" style="width: 100%"></div>
                        </div>
                        <hr>
                        <div class="form-group">
                            {!! Form::checkbox('noko', 'true', true) !!}
                            {!! Form::label('noko', 'Quedarse en el hilo despues de publicar.') !!}
                        </div>
                        @if ( ! Auth::guest())
                            @if (Auth::user()->IsAdmin())
                                <div class="form-group">
                                    {!! Form::checkbox('sticky', '1') !!}
                                    {!! Form::label('sticky', 'Subir hilo a Importantes.') !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::checkbox('locked', '1') !!}
                                    {!! Form::label('locked', 'Cerrar hilo.') !!}
                                </div>
                            @endif
                        @endif
                        <hr>
                        <button type="submit" class="btn btn-default">
                            <i class="glyphicon glyphicon-pencil"></i> Responder
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
            selector: 'div#content'
        });
    </script>
@endsection