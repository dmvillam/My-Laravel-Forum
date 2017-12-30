<ol class="breadcrumb">
    <li><a href="{{ route('forum.board.index') }}"><i class="glyphicon glyphicon-home"></i> Índice de Foros</a></li>
    <li><a href="{{ route('forum.board.index') }}">{{ $board->category->name }}</a></li>
    <li class="active">{{ $board->name }}</li>
</ol>