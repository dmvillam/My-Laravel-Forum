<?php namespace App\Http\Controllers\Forum;

use App\Board;
use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use App\Thread;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class ForumController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('order', 'ASC')->get();
        $boards = Board::orderBy('order', 'ASC')->get();

        return view('forum.index', [
            'categories' => $categories,
            'boards' => $boards,
        ]);
    }

    public function search(Request $request)
    {
        $searching_posts = trim($request->get('posts')) != "" ||
            trim($request->get('thread')) != "" ||
            trim($request->get('board')) != "" ||
            trim($request->get('category')) != "";

        $only_searching_users = trim($request->get('users')) != "" && !$searching_posts;

        if ($only_searching_users)
        {
            $nickname = $request->get('users');
            $nickname = ($nickname=='*')?'':$nickname;
            $fullname = $request->get('name');
            $email = $request->get('email');
            $type = $request->get('type');

            $result = User::nickname($nickname)
                ->fullname($fullname)
                ->email($email)
                ->type($type)
                ->orderBy('nickname', 'ASC')
                ->paginate();

            $show = 'users';
        }
        else if ($searching_posts)
        {
            // actualmente solo es posible realizar búsquedas de posts de los usuarios por su id
            // (lo que significa que si tratas de buscar todos los posts de un usuario según nickname, no va a funcionar)
            // TODO: aprender más formas de búsqueda de Eloquent para poder arreglar problema
            $search_text = $request->get('posts');
            $search_text = ($search_text=='*')?'':$search_text;
            $thread_id = $request->get('thread');
            $thread_id = ($thread_id=='*')?'':$thread_id;
            $board_id = $request->get('board');
            $category_id = $request->get('category');
            $user_id = $request->get('users');
            $user_id = ($user_id=='*')?'':$user_id;
            $op = $request->get('op');

            $result = Post::searchText($search_text)
                ->getThread($thread_id)
                ->getBoard($board_id)
                ->getCategory($category_id)
                ->getUser($user_id)
                ->isOP($op)
                ->orderBy('created_at', 'DESC')     // recent posts first
                ->paginate(10);

            $show = 'posts';
        }
        else
        {
            $result = '';
            $show = 'nothing';
        }
        return view('forum.search', ['result' => $result, 'show' => $show]);
    }
}
