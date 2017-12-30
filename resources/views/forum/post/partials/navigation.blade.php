<ol class="breadcrumb">
    <li><a href="{{ route('forum.board.index') }}"><i class="glyphicon glyphicon-home"></i> Índice de Foros</a></li>
    <li><a href="{{ route('forum.board.index') }}">{{ $thread->board->category->name }}</a></li>
    <li><a href="{{ route('forum.thread.index', $thread->board->id) }}">{{ $thread->board->name }}</a></li>
    <li class="active">{{ $thread->title }}</li>
</ol>