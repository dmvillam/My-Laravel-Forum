<div class="galleryComment" style="margin: {{ $reply_level ? '10px' : '26px' }} 0;"  data-reply-level="{{ $reply_level }}" data-comment-id="{{ $comment->id }}">
    <div style="float: left; margin: 0 16px;">
        @if ( ! $comment->trashed())
            {!! $comment->user->profile->ImgAvatar(60,60) !!}
        @else
            <div class="erasedAvatar">
                <span>X</span>
            </div>
        @endif
    </div>
    <div style="overflow: hidden">
        @if ( ! $comment->trashed())
            <p style="font-size: 0.8em">
                <a href="{{ route('users.profile', $comment->user) }}"><strong>{{ $comment->user->nickname }}</strong></a>
                <i style="color: darkgrey;"> • {{ $comment->created_at->format('d/m/Y') }}</i>
            </p>
            <p>{!! $comment->clean_content !!}</p>
            <p>
                @if (!Auth::guest() && $reply_level <= 2)
                    <a class="commentReply" href="">Responder</a>
                @endif
                @if ($comment->user->id == Auth::user()->id)
                    <a class="commentEdit" href="">Editar</a>
                @endif
                @if ($comment->user->id == Auth::user()->id || Auth::user()->id == $attachment->user->id)
                    <a class="commentDelete" href="" data-toggle="modal" data-target="#ModalDeleteComment">Borrar</a>
                @endif
                {{--TODO: agregar opción de borrado permanente, solo para admins--}}
            </p>
        @else
            <p style="font-size: 0.8em">
                <a href="{{ route('users.profile', $comment->user) }}"><strong>{{ $comment->user->nickname }}</strong></a>
                <i style="color: darkgrey;">Este comentario ha sido eliminado.</i>
            </p>
            @if (Auth::user()->id == $attachment->user->id)
                <p>
                    <a href="" class="commentRestore" data-toggle="modal" data-target="#ModalRestoreComment">Restaurar</a>
                </p>
            @endif
        @endif
    </div>

    @if ($reply_level <= 2)
        <div class="row commentsRow replyRow">
            @foreach(\App\GalleryComment::withTrashed()->where('reply_id', '=', $comment->id)->get() as $reply)
                @include('galleries.attachments.partials.comments', ['comment' => $reply, 'reply_level' => $reply_level + 1])
            @endforeach
        </div>
    @endif

    {{-- here jQuery appends a .comment-form element --}}
</div>
