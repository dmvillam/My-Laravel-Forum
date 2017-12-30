<?php namespace App\Http\Controllers\Forum;

use App\Board;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TagsController;
use App\Http\Requests\CreateThreadRequest;
use App\Post;
use App\Tag;
use App\Thread;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class ThreadController extends Controller
{
    public function index($board_id)
    {
        return view('forum.thread.index', [
            'board' => Board::find($board_id),
            'threads' => Thread::where('board_id', '=', $board_id)
                ->orderBy('updated_at', 'DESC')
                ->paginate(),
        ]);
    }

    public function create($board_id)
    {
        return view('forum.thread.create', [
            'board' => Board::find($board_id),
        ]);
    }

    public function store(CreateThreadRequest $request, $board_id)
    {
        // Filling data
        $user = User::where('nickname', '=', $request['alt-user'])->first();
        $request['user_id'] = $user != null ? $user->id : $request->user()->id;
        $request['board_id'] = $board_id;
        $request['category_id'] = Board::find($board_id)->category->id;
        $request['reply_id'] = 0;

        // Create the thread
        $thread = Thread::create($request->all());

        // Create the post into the thread
        $request['thread_id'] = $thread->id;
        Post::create($request->all());

        // Create the tags into the thread
        TagsController::createTagsFromThread($request['tags'], $thread->id);

        // Returning
        if ($request->noko == true)
        {
            return \Redirect::route('forum.post.index', [$board_id, $thread->id]);
        }
        else return \Redirect::route('forum.thread.index', $board_id);
    }

    public function update(Request $request, $board_id, $thread_id)
    {
        if ($request->action == "lock-thread")
        {
            $thread = Thread::find($thread_id);
            $thread->locked = ($request->locked == 1) ? 0 : 1;
            $thread->save();
        }
        else if ($request->action == "stick-thread")
        {
            $thread = Thread::find($thread_id);
            $thread->sticky = ($request->sticky == 1) ? 0 : 1;
            $thread->save();
        }
        else if ($request->action == "move-thread")
        {
            $thread = Thread::find($thread_id);
            if ($request['move-thread-flag'] == true)
            {
                $new_thread = Thread::create([
                    'title' => '[Movido]: ' . $thread->title,
                    'locked' => 1,
                    'sticky' => 0,
                    'category_id' => $thread->category->id,
                    'board_id' => $thread->board->id,
                    'user_id' => $thread->user->id,
                ]);
                Post::create([
                    'title' => $new_thread->title,
                    'content' =>
                        'El tema [b]' . $thread->title . '[/b] ha sido movido.
Pueden verlo en el nuevo [url=' . route('forum.post.index', [$request['dest-board'], $thread]) . ']enlace[/url].
Gracias por su atención.',
                    'category_id' => $thread->category->id,
                    'board_id' => $thread->board->id,
                    'thread_id' => $new_thread->id,
                    'user_id' => $thread->user->id,
                    'reply_id' => 0,
                ]);
            } else $new_thread = Thread::find($thread->id);
            $thread->board_id = $request['dest-board'];
            $thread->category_id = Board::find($request['dest-board'])->category->id;
            $thread->save();

            foreach ($thread->posts as $post)
            {
                $post->board_id = $request['dest-board'];
                $post->category_id = Board::find($request['dest-board'])->category->id;
                $post->save();
            }
        }
        return \Redirect::route('forum.thread.index', $board_id);
    }

    public function destroy($board_id, $thread_id)
    {
        Thread::destroy($thread_id);
        Post::where('thread_id', '=', $thread_id)->delete();
        Tag::where('thread_id', '=', $thread_id)->delete();
        return \Redirect::route('forum.thread.index', $board_id);
    }
}
