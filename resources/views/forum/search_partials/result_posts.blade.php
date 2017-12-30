{!! $result->appends(Request::all())->render() !!}
@foreach($result as $post)
    <div class="row">
        <div class="col-md-1">
            <a href="{{ route('users.profile', $post->user) }}">
                <div>{!! $post->user->profile->ImgAvatar(75,75) !!}</div>
                <div>Por: {{ $post->user->nickname }}</div>
            </a>
        </div>
        <div class="col-md-11">
            <a href="{{ route('forum.post.index', [$post->board, $post->thread]) }}" class="list-group-item">
                <h4 class="list-group-item-heading">Foro > ({{ $post->category->id }}) {{ $post->category->name }} > ({{ $post->board->id }}) {{ $post->board->name }} > Tema: ({{ $post->thread->id }}) {{ $post->thread->title }}</h4>
                <div class="list-group">
                    <p class="list-group-item-text">
                        {{ $post->content }}
                    </p>
                </div>
                <p class="list-group-item-text">
                    <strong>Publicado en:</strong> {{ date('M d, Y', strtotime($post->created_at)) }}
                </p>
            </a>
        </div>
    </div>
@endforeach
{!! $result->appends(Request::all())->render() !!}
