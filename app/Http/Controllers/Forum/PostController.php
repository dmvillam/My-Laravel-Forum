<?php namespace App\Http\Controllers\Forum;

use App\Board;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TagsController;
use App\Http\Requests\CreatePostRequest;
use App\Post;
use App\Tag;
use App\Thread;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class PostController extends Controller
{
    public function index($board_id, $thread_id)
    {
        $array = ['' => '(Elegir board destino)'];
        foreach (Category::orderBy('order', 'ASC')->get() as $category)
        {
            $array[$category->name] = array();
            foreach (Board::orderBy('order', 'ASC')->get() as $board)
            {
                $array[$category->name][$board->id] = $board->name;
            }
        }

        return view('forum.post.index', [
            'thread' => Thread::find($thread_id),
            'posts' => Post::where('thread_id', '=', $thread_id)->paginate(),
            'move_board_array' => $array,
        ]);
    }

    public function create($board_id, $thread_id)
    {
        return view('forum.post.create', [
            'thread' => Thread::find($thread_id),
        ]);
    }

    public function store(CreatePostRequest $request, $board_id, $thread_id)
    {
        $user = User::where('nickname', '=', $request['alt-user'])->first();
        $user = ($user != null) ? $user : $request->user();

        $request['user_id'] = $user->id;
        $request['thread_id'] = $thread_id;
        $request['board_id'] = Thread::find($thread_id)->board->id;
        $request['category_id'] = Thread::find($thread_id)->board->category->id;
        $request['reply_id'] = Thread::find($thread_id)->posts->last()->reply_id + 1;
        $post = Post::create($request->all());

        if ($request->ajax())
        {
            return response()->json([
                'user' => [
                    'profile_url'        => route('users.profile', $user),
                    'nickname'           => $user->nickname,
                    'profile_avatar_url' => url('/') . '/avatars/' . (($user->profile->avatar == null) ? 'default.png' : $user->profile->avatar),
                    'type'               => config('options.types')[$user->type],
                    'thread_count'       => count($user->threads),
                    'post_count'         => count($user->posts),
                    'website'            => $user->profile->website,
                    'twitter'            => $user->profile->twitter,
                    'country'            => $user->profile->country,
                ],
                'post' => [
                    'title'     => $request->title,
                    'content'   => $post->content,//nl2br(e($request['content'])),
                ],
                'edit_post_url' => route('forum.post.edit', [
                    Board::find($board_id),
                    Thread::find($thread_id),
                    $request->user()->posts->last(),
                ]),
            ]);
        }

        $thread = Thread::find($thread_id);
        $thread->sticky = ($request->sticky == 1) ? 1 : 0;
        $thread->locked = ($request->locked == 1) ? 1 : 0;
        $thread->save();

        if ($request->noko == true)
        {
            return \Redirect::route('forum.post.index', [$board_id, $thread_id]);
        }
        else return \Redirect::route('forum.thread.index', $board_id);
    }

    public function show($board_id, $thread_id, $id)
    {
        return view('');
    }

    public function edit($board_id, $thread_id, $id)
    {
        $post = Post::find($id);
        if ($post->reply_id == 0)
        {
            $post['tags'] = TagsController::implodeTags($post->thread->tags);
        }
        return view('forum.post.edit', [
            'post' => $post,
            'thread' => Thread::find($thread_id),
        ]);
    }

    public function update(CreatePostRequest $request, $board_id, $thread_id, $id)
    {
        // Cambiar autor del post?
        $user = User::where('nickname', '=', $request['alt-user'])->first();
        if ($user != null)
        {
            $request['user_id'] = $user->id;
        }

        // Modificando post
        $post = Post::find($id);
        $thread = Thread::find($thread_id);
        $post->fill($request->all());
        if ($id == $thread->posts->first()->id)
        {
            $thread = $post->thread;
            $thread->title = $post->title;
            $thread->save();
        }
        $post->save();

        // Modificando thread
        $thread->sticky = ($request->sticky == 1) ? 1 : 0;
        $thread->locked = ($request->locked == 1) ? 1 : 0;
        $thread->save();

        // Modificando tags
        if ($id == $thread->posts->first()->id)
        {
            Tag::where('thread_id', '=', $thread_id)->delete();
            TagsController::createTagsFromThread($request['tags'], $thread->id);
        }

        if ($request->noko == true)
        {
            return \Redirect::route('forum.post.index', [Board::find($board_id), Thread::find($thread_id)]);
        }
        else return \Redirect::route('forum.thread.index', Board::find($board_id));
    }

    public function delete($board_id, $thread_id, $id)
    {
        if (Post::find($id)->reply_id == 0)
        {
            Thread::destroy($thread_id);
            foreach (Post::where('thread_id', '=', $thread_id)->get() as $post)
            {
                $post->delete();
            }
        }
        else
        {
            Post::destroy($id);
        }
        return \Redirect::route('forum.post.index', [Board::find($board_id), Thread::find($thread_id)]);
    }
}
