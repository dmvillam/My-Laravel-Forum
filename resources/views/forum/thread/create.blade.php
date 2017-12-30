@extends('layouts.app')

@section('title')
    Nuevo hilo (en: {{ $board->name }})
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Nuevo hilo</div>
                    <div class="panel-body">

                        @include('admin.users.partials.messages')

                        {!! Form::open(['route' => ['forum.thread.store', $board], 'method' => 'POST']) !!}
                        <div class="form-group">
                            {!! Form::label('title', 'Título') !!}
                            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Nombre del hilo']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('tags', 'Etiquetas:') !!}
                            {!! Form::text('tags', null, ['class' => 'form-control', 'placeholder' => 'Escriba las etiquetas separadas por comas.']) !!}
                        </div>
                        @if (Auth::user()->IsAdmin())
                            <div class="form-group">
                                {!! Form::label('alt-user', 'Postear como otro usuario') !!}
                                {!! Form::text('alt-user', null, ['class' => 'form-control', 'placeholder' => 'Inserte nickname de otro usuario']) !!}
                            </div>
                        @endif
                        {{--
                        <div class="form-group">
                            {!! Form::label('content', 'Contenido') !!}
                            {!! Form::hidden('content', null) !!}
                            <div id="commentBoxExpanded">
                                <div style="background: #bff0dc; padding: 3px;">
                                    <ul class="nav nav-pills reply-form" style="cursor: default;">
                                        <li role="presentation"><a title="Negrita" class="tag bold" data-tag="b"><i class="glyphicon glyphicon-bold"></i></a></li>
                                        <li role="presentation"><a title="Cursiva" class="tag italic" data-tag="i"><i class="glyphicon glyphicon-italic"></i></a></li>
                                        <li role="presentation"><a title="Subrayado" class="tag underline" data-tag="u"><i class="fa fa-underline"></i></a></li>
                                        <li role="presentation"><a title="Tachado" class="tag strike" data-tag="s"><i class="fa fa-strikethrough"></i></a></li>
                                        <li class="separator"></li>
                                        <li role="presentation"><a title="Insertar enlace" class="link" data-tag="url"><i class="glyphicon glyphicon-link"></i></a></li>
                                        <li role="presentation"><a title="Insertar cita" class="tag quote" data-tag="quote"><i class="fa fa-quote-right"></i></a></li>
                                        <li role="presentation"><a title="Código" class="tag code" data-tag="code"><i class="fa fa-code"></i></a></li>
                                        <li role="presentation"><a title="Smileys/Emojis" class="smiley"><i class="fa fa-smile-o"></i></a></li>
                                        <li class="separator"></li>
                                        <li role="presentation"><a title="Listados" class="list-ul"><i class="fa fa-list-ul"></i></a></li>
                                        <li role="presentation"><a title="Listado numérico" class="list-ol"><i class="fa fa-list-ol"></i></a></li>
                                        <li class="separator"></li>
                                        <li role="presentation"><a title="Alinear a la izquierda" class="tag align-left" data-tag="left"><i class="glyphicon glyphicon-align-left"></i></a></li>
                                        <li role="presentation"><a title="Alinear al centro" class="tag align-center" data-tag="center"><i class="glyphicon glyphicon-align-center"></i></a></li>
                                        <li role="presentation"><a title="Alinear a la derecha" class="tag align-right" data-tag="right"><i class="glyphicon glyphicon-align-right"></i></a></li>
                                        <li class="separator"></li>
                                        <li role="presentation"><a title="Color de la fuente" class="text-color"><i class="glyphicon glyphicon-text-color"></i></a></li>
                                        <li role="presentation"><a title="Tamaño de la fuente" class="text-size"><i class="glyphicon glyphicon-text-size"></i></a></li>
                                    </ul>
                                </div>
                                <div role="textbox" contenteditable="true" style="background: white; padding: 5px; display: block; overflow: auto; min-height: 120px; max-height: 600px;"></div>
                                <div style="background: #bff0dc; padding: 4px;">
                                    <i class="glyphicon glyphicon-paperclip btn-lg"></i>
                                    <a href="" class="uploadAttachment">
                                        Subir un adjunto
                                    </a>
                                    <ul class="nav nav-pills pull-right reply-form" style="padding: 6px;">
                                        <li role="presentation" class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                                Insertar adjunto existente <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="">Desde galerías</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <div class="form-group" style="display:none">
                                        <input type="file" id="attachment" name="attachment">
                                    </div>
                                </div>
                            </div>
                        </div>
                        --}}
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
                            <i class="glyphicon glyphicon-pencil"></i> Crear nuevo hilo
                        </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{--<script src="{{ url('/') . '/js/enhanced_form_manager.js' }}"></script>

    <script>
        $('form').find('button').click(function (e) {
            e.preventDefault();
            var createThreadForm = $(this).closest('form');
            var comment = createThreadForm.find("div[role='textbox']").html().replace(/<br>/gi, '\n');
            createThreadForm.find('input[name="content"]').val(comment);
            createThreadForm.submit();
        });
    </script>
    --}}

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