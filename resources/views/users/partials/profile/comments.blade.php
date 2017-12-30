<!-- Formulario para dejar mensajes de visita -->
@if ( ! Auth::guest())
    {!! Form::open(['route' => ['profile.comment.store', $user], 'method' => 'POST', 'class' => 'comment-form']) !!}
    {!! Form::hidden('reply_level', 1) !!}
    <div class="panel-default">
        <div class="row">
            <div class="col-md-1 col-md-offset-1">
                {!! Auth::user()->profile->ImgAvatar(45,45) !!}
            </div>
            <div class="col-md-7">
                <div class="form-horizontal-sm">
                    {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => 1, 'placeholder' => 'Escríbale algo a ' . $user->nickname . '...', 'required' => 'required']) !!}
                </div>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-info">Comentar</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <hr>
@endif


@if (count($user->profile->comments) > 0)
        <!-- Mensajes de visita -->
    @foreach($user->profile->comments()->where('reply_level', '=', 1)->orderBy('created_at', 'DESC')->get() as $comment)

        <div class="panel">
            <div class="row comment" id="{{ $comment->id }}">
                <div class="col-md-1">
                    <a href="{{ route('users.profile', $comment->user) }}">
                        {!! $comment->user->profile->ImgAvatar(50,50) !!}
                    </a>
                </div>
                <div class="col-md-11">
                    <div class="row">
                        <div class="col-md-11"><p><strong>{{ $comment->user->nickname }}</strong></p></div>
                        <div class="col-md-1">
                            <a href="#" class="btn-edit" data-toggle="modal" data-target="#ModalEditComment"><i class="glyphicon glyphicon-pencil"></i></a>
                            <a href="#" class="btn-delete"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </div>
                    <p class="content">{!! $comment->clean_content !!}</p>
                    <div class="row pls-rspnd">
                        <div class="col-md-12"><a href="#">Responder</a></div>
                    </div>
                    <div class="row replies" style="{{ (count($comment->replies) == 0) ? 'display:none' : '' }}">
                        <div class="col-md-11">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    @foreach($comment->replies as $reply)
                                        <div class="row comment reply" id="{{ $reply->id }}">
                                            <div class="col-md-1">
                                                <a href="{{ route('users.profile', $reply->user) }}">
                                                    {!! $reply->user->profile->ImgAvatar(40,40) !!}
                                                </a>
                                            </div>
                                            <div class="col-md-11">
                                                <div class="row">
                                                    <div class="col-md-11"><p><strong>{{ $reply->user->nickname }}</strong></p></div>
                                                    <div class="col-md-1">
                                                        <a href="#" class="btn-edit" data-toggle="modal" data-target="#ModalEditComment"><i class="glyphicon glyphicon-pencil"></i></a>
                                                        <a href="#" class="btn-delete"><i class="glyphicon glyphicon-remove"></i></a>
                                                    </div>
                                                </div>
                                                <p class="content">{!! $reply->clean_content !!}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                                <!-- Formulario para responder a mensajes de visita -->
                                        @if ( ! Auth::guest())
                                            {!! Form::open(['route' => ['profile.comment.store', $user], 'method' => 'POST', 'style' => 'display:none', 'class' => 'reply-form']) !!}
                                            {!! Form::hidden('reply_level', 2) !!}
                                            {!! Form::hidden('profile_comment_id', $comment->id) !!}
                                            <div class="panel-default">
                                                <div class="row">
                                                    <div class="col-md-1">
                                                        {!! Auth::user()->profile->ImgAvatar(34,34) !!}
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="form-horizontal-sm">
                                                            {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => 1, 'style' => 'height:34px', 'placeholder' => 'Pls rspnd...', 'required' => 'required']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="submit" class="btn btn-info">Comentar</button>
                                                    </div>
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <p><i>Este usuario aún no tiene mensajes de visita. Sé el primero en dejarle uno.</i></p>
@endif

