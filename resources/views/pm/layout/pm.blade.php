@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-offset-1 col-lg-10">
            <div class="panel panel-default">
                <div class="panel panel-title">
                    <a href="{{ route('forum.board.index') }}">Índice de Foros</a>
                    >
                    Mensajería privada
                </div>
            </div>
            <p>
                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#ModalStartConversation">
                    Nuevo mensaje
                </a>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-offset-1 col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">Carpetas</div>
                <div class="panel-body">
                    <div class="list-group">
                        @foreach (Auth::user()->folders as $folder)
                            <a
                                    href="{{ (($folder->id == \App\PmFolder::first()->id) ? route('users.pm.index') : route('users.pm.index', $folder)) }}"
                                    class="list-group-item {{ ($folder->id == $folder_id) ? 'active' : '' }}"
                            >
                                {{ $folder->folder_name }}
                                <?php $alerts = Auth::user()->pm_alerts()->where('is_read', '=', 0)->get() ?>
                                <span class="badge" style="background:#ad1457;color:white;">{{ (count($alerts) > 0) ? count($alerts) : '' }}</span>
                            </a>
                        @endforeach
                    </div>
                    <p><a href="#" class="btn btn-default" data-toggle="modal" data-target="#ModalCreateFolder"><i></i>Crear carpeta</a></p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ Auth::user()->folders()->find($folder_id)->folder_name }} - Conversaciones
                </div>
                <div class="panel-body">
                    @if (count(Auth::user()->folders()->find($folder_id)->conversations) > 0)
                        @foreach(Auth::user()->folders()->find($folder_id)->conversations as $conversation)
                            <div class="list-group">
                                <a href="{{ route('users.pm.conversation', [$conversation->folders()->find($folder_id), $conversation]) }}" class="list-group-item" title="Conversación iniciada por {{ $conversation->messages->first()->user->nickname }}">
                                    <div class="row">
                                        <div class="col-md-2">
                                            {!! $conversation->messages->first()->user->profile->ImgAvatar(40,40,'img-rounded') !!}
                                        </div>
                                        <div class="col-md-10">
                                            <h5 class="list-group-item-heading">{{ $conversation->subject }}</h5>
                                            <p class="list-group-item-text">{{ mb_strimwidth($conversation->messages->first()->content, 0, 50, "...") }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                    @endif
                </div>
            </div>
        </div>

        <!--
          -- Modals
          -->
        {!! Form::open(['route' => 'pm.folder.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        {!! Form::hidden('user_id', Auth::user()->id) !!}
        <div class="modal fade" id="ModalCreateFolder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Crear nueva carpeta</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {!! Form::label('folder_name', 'Nombre:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-8">
                                {!! Form::text('folder_name', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la carpeta', 'required']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('folder_desc', 'Descripción:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-8">
                                {!! Form::textarea('folder_desc', null, ['class' => 'form-control', 'placeholder' => 'Ingrese una breve descripción', 'rows' => 2]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}


        {!! Form::open(['route' => 'pm.conversation.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        {!! Form::hidden('user_id', Auth::user()->id) !!}
        <div class="modal fade" id="ModalStartConversation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Iniciar nueva conversación</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {!! Form::label('dest_users', 'Destinatario:', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                {!! Form::text('dest_users', null, ['class' => 'form-control', 'placeholder' => 'Agregue uno o más usuarios, separados por comas', 'required']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('subject', 'Asunto:', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                {!! Form::text('subject', null, ['class' => 'form-control', 'placeholder' => 'Agregue el asunto del mensaje']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('content', 'Mensaje:', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el mensaje', 'required']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

        @yield('conversations')

    </div>
@endsection

@section('scripts')
    <script></script>
@endsection
