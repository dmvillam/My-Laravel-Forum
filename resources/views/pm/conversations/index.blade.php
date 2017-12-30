@extends('pm.layout.pm')

@section('conversations')
    <div class="col-lg-7">
        <div class="panel">
                <p>
                    <i class="glyphicon glyphicon-user"></i><i>Miembros de esta conversación.</i>
                    <span class="pull-right">
                        <a href="#" data-toggle="modal" data-target="#ModalDeleteConversation">
                            <i class="glyphicon glyphicon-trash"></i>Eliminar conversación.
                        </a>
                    </span>
                </p>
            <div class="row">
                @foreach($conversation->users as $user)
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-3">
                                {!! $user->profile->ImgAvatar(40,40) !!}
                            </div>
                            <div class="col-md-9">
                                <div><strong>{{ $user->nickname }}</strong></div>
                                <div>otra info por definir</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <hr>

            <div class="panel-default">
                <div class="panel-heading">
                    <strong>Asunto: {{ $conversation->subject }}</strong>
                </div>
                <div class="panel-body">
                    @foreach($conversation->messages as $message)
                        <div class="row">
                            <div class="col-md-1">
                                <div>{!! $message->user->profile->ImgAvatar(60,60, 'img-rounded') !!}</div>
                            </div>
                            <div class="col-md-11">
                                <p><strong>{{ $message->user->nickname }}</strong></p>
                                <p>{!! nl2br(e($message->content)) !!}</p>
                            </div>
                        </div>
                        <hr>
                    @endforeach

                    {!! Form::open(['route' => ['pm.conversation.reply', $folder, $conversation], 'method' => 'POST']) !!}
                    {!! Form::hidden('user_id', Auth::user()->id) !!}
                    {!! Form::hidden('dest_users', 'dummy') !!}
                    <div class="row">
                        <div class="col-md-1">
                            {!! Auth::user()->profile->ImgAvatar(40,40) !!}
                        </div>
                        <div class="col-md-9">
                            {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Escribir nueva respuesta.', 'rows' => 2, 'required']) !!}
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-default">Enviar</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

                {!! Form::open(['route' => ['pm.conversation.delete', $folder, $conversation], 'method' => 'DELETE', 'class' => 'form-horizontal']) !!}
                <div class="modal fade" id="ModalDeleteConversation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Eliminar conversación</h4>
                            </div>
                            <div class="modal-body">
                                <p>Está por eliminar una conversación de su buzón de mensajes privados junto con todos sus comentarios.</p>
                                <p>¿Desea continuar?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Aceptar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection