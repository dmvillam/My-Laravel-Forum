<div class="panel panel-default">
    <div class="panel-heading" style="background-image: url('{{ $user->profile->img_url }}'); background-size: cover; background-position: top center; height: 200px; position: relative">
        <div style="position: absolute; top: 5px; right: 5px;">
            <div style="float: left">
                <a class="btn btn-info" href="{{ route('users.edit', $user) }}" role="button">
                    <i class="glyphicon glyphicon-plus"></i> Editar Perfil
                </a>
            </div>
            <div style="float: left">
                <a class="btn btn-info" href="#" role="button" data-toggle="modal" data-target="#ModalProfileImage">
                    <i class="glyphicon glyphicon-picture"></i> Imagen de perfil
                </a>
            </div>
        </div>
        <div class="dropdown" style="position: absolute; bottom: 5px; right: 5px; z-index: 1;">
            <a href="" class="btn btn-info" role="button" data-toggle="dropdown">
                <i class="glyphicon glyphicon-option-vertical"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li><a href="#"><i class="glyphicon glyphicon-user"></i> Solicitar amistad</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-ok"></i> Seguir</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-envelope"></i> Enviar MP</a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <div class="row" style="margin-top: -100px;">
            <div class="col-md-3" style="display: inline-block; text-align: center">{!! $user->profile->ImgAvatar(150,150) !!}</div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6" style="text-shadow: 0px 0px 10px black; color: white;">
                        <h2>{{ $user->nickname }}</h2>
                        <h4>{{ config('options.types')[$user->type] }}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <div>Hilos</div>
                        <div>{{ count($user->threads) }}</div>
                    </div>
                    <div class="col-md-1">
                        <div>Posts</div>
                        <div>{{ count($user->posts) }}</div>
                    </div>
                    <div class="col-md-3">
                        <div>Fecha de registro</div>
                        <div>{{ $user->created_at ? $user->created_at->format('F jS Y') : 'Nula' }}</div>
                    </div>
                    <div class="col-md-1">
                        <div>Sexo</div>
                        <div>{{ $user->profile->text_gender }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="position: absolute; top: 230px; left: 40px;">
    <a class="btn btn-default btn-avatar" href="" role="button" data-toggle="modal" data-target="#ModalEditAvatar">
        <i class="glyphicon glyphicon-picture"></i>
    </a>
</div>

<div class="panel panel-default">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a aria-expanded="true" href="#home" aria-controls="home" role="tab" data-toggle="tab">Mensajes de Visita</a></li>
        <li class="" role="presentation"><a aria-expanded="false" href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Perfil</a></li>
        <li class="" role="presentation"><a aria-expanded="false" href="#contact" aria-controls="contact" role="tab" data-toggle="tab">Contacto</a></li>
        <li class="" role="presentation"><a aria-expanded="false" href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Actividad</a></li>
        <li class="" role="presentation"><a aria-expanded="false" href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Configuración</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade active in" id="home">
            <div class="panel-body">
                @include('users.partials.profile.comments')
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="profile">
            <div class="panel-body">
                <p><a><i class="glyphicon glyphicon-pencil"></i></a> <strong>Nombre:</strong> {{ $user->fullname }}</p>
                <p><a><i class="glyphicon glyphicon-pencil"></i></a> <strong>País:</strong> {{ $user->profile->country }}</p>
                <p><a><i class="glyphicon glyphicon-pencil"></i></a> <strong>Acerca de {{ $user->nickname }}:</strong> {!! nl2br(e($user->profile->bio)) !!}</p>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="contact">
            <div class="panel-body">
                <p><a><i class="glyphicon glyphicon-pencil"></i></a> <strong>Correo Electrónico:</strong> {{ $user->email }}</p>
                <p><a><i class="glyphicon glyphicon-pencil"></i></a> <strong>Website:</strong> {{ $user->profile->website }}</p>
                <p><a><i class="glyphicon glyphicon-pencil"></i></a> <strong>Twitter:</strong> {{ $user->profile->twitter }}</p>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="messages">
            <div class="panel-body">
                <p>
                    <a href="{{ route('user.threads.list', $user) }}">
                        <i class="glyphicon glyphicon-th-list"></i>Hilos creados por {{ $user->nickname }}
                    </a>
                </p>
                <p>
                    <a href="{{ route('user.posts.list', $user) }}">
                        <i class="glyphicon glyphicon-tasks"></i>Posts hechos por {{ $user->nickname }}
                    </a>
                </p>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="settings">
            <div class="panel-body">
                <p>No hay nada para configurar por los momentos, esta sección se encuentra en construcción.</p>
            </div>
        </div>
    </div>
</div>

<!--
  -- Modals
  -->
<div class="modal fade" id="ModalEditAvatar" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['route' => ['users.avatar.update', $user->profile], 'method' => 'PUT', 'files' => true]) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Actualizar avatar de: {{ $user->nickname }}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('avatar', 'Subir Avatar') !!}
                    <input name="avatar" id="avatar" type="file" required="required">
                    {{--{!! Form::file('avatar', null) !!}--}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary save-avatar">Guardar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEditAvatarError" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Error</h4>
            </div>
            <div class="modal-body">
                <p>No haz elegido ningún archivo.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalProfileImage" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['route' => ['users.profile_img.update', $user->profile], 'method' => 'PUT', 'files' => true]) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Imagen de perfil de: {{ $user->nickname }}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('profile_img', 'Imagen del perfil') !!}
                    <input name="profile_img" id="profile_img" type="file" required="required">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary save-avatar">Guardar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

{!! Form::open(['route' => ['profile.comment.delete', $user, ':COMMENT_ID'], 'method' => 'DELETE', 'id' => 'form-delete']) !!}
{!! Form::close() !!}

<div class="modal fade" id="ModalDeleteComment" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-alert"></i> Error</h4>
            </div>
            <div class="modal-body">
                <p>Estás apunto de borrar el comentario. ¿Deseas continuar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Si</button>
            </div>
        </div>
    </div>
</div>

{!! Form::hidden('generic_route', route('profile.comment.update', [$user, ':COMMENT_ID']), ['class' => 'hidden-edit-route']) !!}
{!! Form::open(['route' => ['profile.comment.update', $user, ':COMMENT_ID'], 'method' => 'PUT', 'id' => 'form-edit']) !!}
<div class="modal fade" id="ModalEditComment" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar comentario</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Insertar comentario...']) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Cambiar</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
