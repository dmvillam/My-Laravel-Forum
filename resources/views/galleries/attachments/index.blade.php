@extends('layouts.app')

@section('title')
    {{ $attachment->original_name }} - {{ $attachment->gallery->title }}
@endsection

@section('styles')
    <style>
        .attachmentView {
            background-color: #f5f5f5;
            width: 90%;
            height: 500px;
            margin: auto;
            position: relative;
        }
        #attachmentShow {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            max-width: 100%;
            max-height: 100%;
            margin: auto;
        }
        .reply-form > li > a {
            padding: 7px 12px;
            color: black;
        }
        .reply-form > li.separator {
            float: left;
            background-color: #c0c0c0;
            background-color: rgba(0,0,0,.2);
            margin: 0;
            height: 40px;
            width: 1px;
        }
        .reply-form > li > a:hover {
            background-color: #a1cbba;
        }
        .reply-form > .dropdown > a {
            background-color: #addac7;
        }
        #form-store-comment button {
            margin: 5px;
        }
        .commentsRow {
            margin-left: 15px;
        }
        .replyRow {
            margin-left: 75px;
        }
        .erasedAvatar {
            width: 60px;
            height: 60px;
            border-radius: 30px;
            background: darkgray;
        }
        .erasedAvatar > span {
            color: white;
            font-size: 3.2em;
            font-weight: bold;
            padding-left: 14px;
        }
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

    @include('galleries.attachments.partials.navigation')

    <div class="attachmentView">
        <img id="attachmentShow" src="{{ url('/') }}/attachments/{{ $attachment->file_name }}" style="">
    </div>

    <div class="container">
        <h2>{{ $attachment->original_name }}</h2>
        <div class="row" style="margin: 16px 0;">
            <div style="float:left; margin-left: 8px;">
                <a href="{{ route('users.profile', $attachment->user) }}">{!! $attachment->user->profile->ImgAvatar(45,45) !!}</a>
            </div>
            <div style="float:left; margin-left: 8px;">
                <div>Por <a href="{{ route('users.profile', $attachment->user) }}">{{ $attachment->user->nickname }}</a></div>
                <div>{{ $attachment->created_at->diffForHumans() }}</div>
            </div>
        </div>
        <p>{!! $attachment->details->clean_desc !!}</p>
        <p style="font-size: 0.9em">
            Etiquetas:
            @if (count($tags) > 0)
                @foreach($tags as $tag)
                    <a href="{{ route('galleries.index') }}?tags={{$tag}}"><span class="tags">{{ $tag }}</span></a>
                @endforeach
            @else
                <i>Ninguna</i>.
            @endif
        </p>
        <hr />
        <ul class="nav nav-pills pull-right">
            <li role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    Moderar imagen <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('attachment.details.edit', $attachment) }}"><i class="glyphicon glyphicon-edit"></i> Editar detalles</a></li>
                    <li><a href=""><i class="glyphicon glyphicon-star-empty"></i> Establecer como imagen destacada</a></li>
                    <li><a href=""><i class="glyphicon glyphicon-pushpin"></i> Fijar imagen</a></li>
                    <li><a href=""><i class="glyphicon glyphicon-remove"></i> Ocultar imagen</a></li>
                    <li><a href=""><i class="glyphicon glyphicon-lock"></i> Desactivar comentarios</a></li>
                    <li><a href=""><i class="glyphicon glyphicon-share"></i> Mover imagen</a></li>
                    <li><a class="attachmentDelete" href="" data-toggle="modal" data-target="#ModalDeleteAttachment"><i class="glyphicon glyphicon-trash"></i> Borrar imagen</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="">Historial de moderación</a></li>
                </ul>
            </li>
            <li role="presentation" class="active">
                <a href="" role="button">
                    <i class="fa fa-exclamation-triangle"></i> Reportar imagen
                </a>
            </li>
        </ul>
        <h1>Comentarios</h1>

        <div class="row commentsRow">
            @if (count($comments) > 0)
                @foreach($comments->where('reply_id', '=', 0) as $comment)
                    @include('galleries.attachments.partials.comments', ['comment' => $comment, 'reply_level' => 0])
                @endforeach
            @else
                <p style="margin-bottom: 40px;"><i>No hay comentarios que mostrar.</i></p>
            @endif
        </div>

        @if ( ! Auth::guest())
            @include('common.form')
        @endif
    </div>

    {{--
    -- Modals
    --}}
    <div class="modal fade" id="ModalDeleteComment" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="glyphicon glyphicon-alert"></i> Borrar comentario:</h4>
                </div>
                <div class="modal-body">
                    <p>Está por borrar el comentario ¿desea continuar?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-alert"></i> Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalRestoreComment" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="glyphicon glyphicon-alert"></i> Restaurar comentario:</h4>
                </div>
                <div class="modal-body">
                    <p>Está por restaurar el comentario ¿desea continuar?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-alert"></i> Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalDeleteAttachment" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="glyphicon glyphicon-alert"></i> Borrar Imagen de Galerías:</h4>
                </div>
                <div class="modal-body">
                    <p>Está por borrar la imagen, ¿desea continuar?</p>
                </div>
                <div class="modal-footer">
                    {!! Form::open(['route' => ['gallery.attachments.destroy', $attachment], 'method' => 'DELETE', 'id' => 'form-delete-attachment']) !!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-alert"></i> Confirmar</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    @if ( ! Auth::guest())
        {!! Form::open(['route' => 'gallery.comment.store', 'method' => 'POST', 'id' => 'form-store-comment']) !!}
        {!! Form::hidden('user_id', Auth::user()->id) !!}
        {!! Form::hidden('gallery_id', $attachment->gallery->id) !!}
        {!! Form::hidden('attachment_id', $attachment->id) !!}
        {!! Form::hidden('reply_id', null) !!}
        {!! Form::hidden('content', null) !!}
        {!! Form::close() !!}

        {!! Form::open(['route' => ['gallery.comment.update', ':COMMENT_ID'], 'method' => 'PUT', 'id' => 'form-update-comment']) !!}
        {!! Form::hidden('content', null) !!}
        {!! Form::close() !!}

        {!! Form::open(['route' => ['gallery.comment.destroy', ':COMMENT_ID'], 'method' => 'DELETE', 'id' => 'form-delete-comment']) !!}
        {!! Form::close() !!}
    @endif

    @include('galleries.attachments.partials.navigation')
@endsection

@section('scripts')
    <script src="{{ url('/') . '/js/enhanced_form_manager.js' }}"></script>

    <script id="commentTemplate" type="text/template">
        <div class="galleryComment" style="margin: 26px 0;">
            <div style="float: left; margin: 0 16px;">
                <img src="" class="img-circle user-avatar-url" style="max-width: 60px; max-height: 60px;">
            </div>
            <div style="overflow: hidden">
                <p style="font-size: 0.8em;">
                    <a href="" class="user-profile-url"><strong class="user-nickname"></strong></a>
                    <i style="color: darkgrey;"> • <span class="created-at"></span></i>
                </p>
                <p class="content"></p>
                <p>
                    <a class="commentReply" href="">Responder</a>
                    <a class="commentEdit" href="">Editar</a>
                    <a class="commentDelete" href="" data-toggle="modal" data-target="#ModalDeleteComment">Borrar</a>
                </p>
            </div>
        </div>
    </script>

    <script id="replyFormTemplate" type="text/template">
        <div class="row comment-form" style="background: #d5d5d5; padding: 6px; margin: 0 15px; display: table; width: 100%">
            <div style="display: table-cell; width: 0; padding: 0 5px;">
                @if ( ! Auth::guest())
                    {!! Auth::user()->profile->ImgAvatar(30,30) !!}
                @endif
            </div>
            <div role="textbox" contenteditable="true" style="background: white; padding: 5px; overflow: auto; min-height: 30px; max-height: 600px; margin-left: 38px; display: table-cell;"></div>
            <div style="display: table-cell; width: 0;">
                <button class="btn btn-primary submit-comment" style="border-radius: 0; height: 30px; padding: 5px;">Comentar</button>
            </div>
        </div>
    </script>

    <script id="editFormButtons" type="text/template">
        <button class="btn btn-default">Cancelar</button>
        <button class="btn btn-primary" style="margin-left: 5px">Modificar</button>
    </script>

    <script>
        $('.uploadAttachment').click(function (e) {
            e.preventDefault();
            $("#attachment").click();
        });

        $('body').on('click', '.submit-comment', function (e) {
            e.preventDefault();
            //TODO: ¿y si el usuario postea una respuesta vacía?
            var commentForm = $(this).closest('.comment-form');
            var reply_level = commentForm.closest('.galleryComment').data('reply-level');
            $('.submit-comment').prop('disabled', true).text('Comentando...');
            var comment = commentForm.find("div[role='textbox']").html().replace(/<br>/gi, '\n');
            var formStoreComment = $('#form-store-comment');
            formStoreComment.find('input[name="content"]').val(comment);
            formStoreComment.find('input[name="reply_id"]').val($(this).data('reply-id'));
            var action = formStoreComment.attr('action');
            var fd = new FormData(document.querySelector("#form-store-comment"));
            $.ajax({
                url: action, // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: fd, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData: false,        // To send DOMDocument or non processed data file it is set to false
                success: function(data)   // A function to be called if request succeeds
                {
                    var commentTemplate = $('#commentTemplate');
                    var commentPlace = commentForm.prev('.commentsRow');
                    commentPlace.append(commentTemplate.html());
                    commentPlace.find('.user-avatar-url').last().attr('src', data.user_avatar_url);
                    commentPlace.find('.user-profile-url').last().attr('href', data.user_profile_url);
                    commentPlace.find('.user-nickname').last().text(data.user_nickname);
                    commentPlace.find('.created-at').last().text(data.created_at);
                    commentPlace.find('.content').last().html(data.my_content.replace(/(<([^>]+)>)/ig,"").replace(/\n/g, "<br>"));
                    commentPlace.find('.galleryComment').css('margin', (reply_level ? '10' : '26') + 'px 0');
                    $('.submit-comment').prop('disabled', false).text('Comentar');
                    $("div[role='textbox']").text('');
                    $('input[name="content"]').val('');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + ', ' + thrownError + '\n');
                    $('.submit-comment').prop('disabled', false).text('Comentar');
                }
            });
        }).on('click', '.commentReply', function (e) {
            e.preventDefault();
            var galleryComment = $(this).closest('.galleryComment');
            if (galleryComment.data('reply-level') > 2)
            {
                alert ('No es posible seguir agregando niveles inferiores de respuestas.');
                return;
            }
            var commentForm = galleryComment.children('.comment-form');
            if (commentForm.length > 0)
            {
                commentForm.toggle().find("div[role='textbox']").focus();
            }
            else
            {
                var replyId = galleryComment.data('comment-id');
                var replyFormTemplate = $('#replyFormTemplate');
                galleryComment.append(replyFormTemplate.html());
                galleryComment.find('.comment-form').find('button').data('reply-id', replyId);
                galleryComment.find('.comment-form').find("div[role='textbox']").focus();
            }
        }).on('click', '.commentEdit', function (e) {
            e.preventDefault();
            //TODO: ¿y si el usuario edita con una respuesta vacía?
            var editingComment = $(this).parent('p').prev('p');
            var contentToEdit = editingComment.text();
            var commentBoxToInsert = $('#commentBoxExpanded').clone();
            commentBoxToInsert.find('div.row').empty()
                    .append(
                            $('<button>').addClass('btn btn-primary pull-right executeEdit').text('Editar').css('margin-left', '5px').click(function () {
                                var thisButton = $(this);
                                thisButton.prop('disabled', true).text('Editando...');
                                var parentP = thisButton.closest('.editingComment').parent('p');
                                var formUpdateComment = $('#form-update-comment');
                                var comment = $(this).closest('.editingComment').find('div[role="textbox"]').html().replace(/<br>/gi, '\n');
                                formUpdateComment.find('input[name="content"]').val(comment);
                                var action = formUpdateComment.attr('action').replace(':COMMENT_ID', thisButton.closest('.galleryComment').data('comment-id'));
                                var fd = new FormData(document.querySelector("#form-update-comment"));
                                $.ajax({
                                    url: action, // Url to which the request is send
                                    type: "POST",             // Type of request to be send, called as method
                                    data: fd, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                                    contentType: false,       // The content type used when sending data to the server.
                                    cache: false,             // To unable request pages to be cached
                                    processData: false,        // To send DOMDocument or non processed data file it is set to false
                                    success: function(data)   // A function to be called if request succeeds
                                    {
                                        parentP.text(data.my_content);
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                        alert(xhr.status + ', ' + thrownError + '\n');
                                        thisButton.prop('disabled', false).text('Editar');
                                    }
                                });
                            })
                    )
                    .append(
                            $('<button>').addClass('btn btn-default pull-right cancelEdit').text('Cancelar').click(function () {
                                $(this).closest('.editingComment').parent('p').text(contentToEdit);
                            })
                    );
            commentBoxToInsert.removeAttr('id').show();
            editingComment.html( $('<div>').addClass('editingComment').append(commentBoxToInsert) );
            editingComment.find('div[role="textbox"]').text(contentToEdit);
        }).on('click', '.commentDelete, .commentRestore', function (e) {
            e.preventDefault();
            var formDeleteComment = $('#form-delete-comment');
            var action = formDeleteComment.attr('action').replace(':COMMENT_ID', $(this).closest('.galleryComment').data('comment-id'));
            formDeleteComment.data('action', action);
        });

        $('#ModalDeleteComment button:last-child, #ModalRestoreComment button:last-child').click(function (e) {
            e.preventDefault();
            var triggerElemId = $(this).closest('.modal').attr('id');
            var action = $('#form-delete-comment').data('action');
            var fd = new FormData(document.querySelector("#form-delete-comment"));
            $.ajax({
                url: action,                // Url to which the request is send
                type: "POST",               // Type of request to be send, called as method
                data: fd,                   // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,         // The content type used when sending data to the server.
                cache: false,               // To unable request pages to be cached
                processData: false,         // To send DOMDocument or non processed data file it is set to false
                success: function(data)     // A function to be called if request succeeds
                {
                    var galleryComment = $('.galleryComment[data-comment-id="' + data.id + '"]');
                    if (triggerElemId == 'ModalDeleteComment')
                    {
                        galleryComment.children('div').first().empty().append(
                                $('<div>').addClass('erasedAvatar').append($('<span>').text('X'))
                        );
                        galleryComment.children('div:nth-child(2)').children('p:first').children('i').text('Este comentario ha sido eliminado.');
                        galleryComment.children('div:nth-child(2)').children('p:nth-child(3)').children('.commentReply').remove();
                        galleryComment.children('div:nth-child(2)').children('p:nth-child(3)').children('.commentEdit').remove();
                        galleryComment.children('div:nth-child(2)').children('p:nth-child(3)').children('.commentDelete').removeClass('commentDelete').addClass('commentRestore').attr('data-target', '#ModalRestoreComment').text('Restaurar');
                        galleryComment.children('div:nth-child(2)').children('p:nth-child(2)').remove();
                    }
                    else if (triggerElemId == 'ModalRestoreComment')
                    {
                        galleryComment.children('div:not(.commentsRow)').remove();
                        galleryComment.prepend($('#commentTemplate').html());
                        var trueContent = galleryComment.children('.galleryComment').html();
                        galleryComment.children('.galleryComment').remove();
                        galleryComment.prepend(trueContent);
                        galleryComment.find('.user-avatar-url').last().attr('src', data.user_avatar_url);
                        galleryComment.find('.user-profile-url').last().attr('href', data.user_profile_url);
                        galleryComment.find('.user-nickname').last().text(data.user_nickname);
                        galleryComment.find('.created-at').last().text(data.created_at);
                        galleryComment.find('.content').last().html(data.my_content);
                    }
                    $( '#' + triggerElemId ).modal('hide');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + ', ' + thrownError + '\n');
                }
            });
        });
    </script>
@endsection