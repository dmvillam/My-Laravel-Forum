<?php $posts = \App\Post::where('thread_id', '=', $thread->id)->paginate();
//$posts->setPath(route('forum.post.index', [$thread->board, $thread])); ?>
@if ($posts->lastPage() > 1)
    - Páginas:
    @for($i=1; $i<=$posts->lastPage(); $i++)
        <a href="{{ route('forum.post.index', [$thread->board, $thread]) . '?page=' . $i }}">{{ $i }}</a>
    @endfor
@endif

<?php
/*
 * TODO: hay que construir una mejor lógica de paginación, una que evite mostrar 500 números
 * en casos extremos de que un hilo tenga 500 páginas!!
 */
?>