<?php namespace App\Http\Controllers\Blogs;

use App\EntryReply;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEntryReplyRequest;
use Illuminate\Http\Request;

use App\Http\Requests;

class EntryRepliesController extends Controller
{
    public function index($entry_id)
    {
        $entry_replies = EntryReply::withTrashed()
            ->where('entry_id', '=', $entry_id)
            ->where('reply_id', '=', 0)
            ->get();
        $comments = array();
        foreach ($entry_replies as $index => $reply)
        {
            $comments[$index]['id'] = $reply->id;
            $comments[$index]['user_id'] = $reply->user_id;
            $comments[$index]['blog_id'] = $reply->blog_id;
            $comments[$index]['entry_id'] = $reply->entry_id;
            $comments[$index]['reply_id'] = $reply->reply_id;
            $comments[$index]['content'] = $reply->content;
            $comments[$index]['created_at'] = $reply->created_at->format('l jS \\of F Y \a\t h:i A');
            $comments[$index]['nickname'] = $reply->user->nickname;
            $comments[$index]['avatar_url'] = $reply->user->profile->avatar_url;
            $comments[$index]['deleted'] = $reply->trashed();
            $replies = EntryReply::withTrashed()
                ->where('entry_id', '=', $entry_id)
                ->where('reply_id', '=', $reply->id)
                ->get();
            foreach ($replies as $index2 => $reply2)
            {
                $comments[$index]['replies'][$index2]['id'] = $reply2->id;
                $comments[$index]['replies'][$index2]['user_id'] = $reply2->user_id;
                $comments[$index]['replies'][$index2]['blog_id'] = $reply2->blog_id;
                $comments[$index]['replies'][$index2]['entry_id'] = $reply2->entry_id;
                $comments[$index]['replies'][$index2]['reply_id'] = $reply2->reply_id;
                $comments[$index]['replies'][$index2]['content'] = $reply2->content;
                $comments[$index]['replies'][$index2]['created_at'] = $reply2->created_at->format('l jS \\of F Y \a\t h:i A');
                $comments[$index]['replies'][$index2]['nickname'] = $reply2->user->nickname;
                $comments[$index]['replies'][$index2]['avatar_url'] = $reply2->user->profile->avatar_url;
                $comments[$index]['replies'][$index2]['deleted'] = $reply2->trashed();
                $subreplies = EntryReply::withTrashed()
                    ->where('entry_id', '=', $entry_id)
                    ->where('reply_id', '=', $reply2->id)
                    ->get();
                foreach ($subreplies as $index3 => $reply3)
                {
                    $comments[$index]['replies'][$index2]['replies'][$index3]['id'] = $reply3->id;
                    $comments[$index]['replies'][$index2]['replies'][$index3]['user_id'] = $reply3->user_id;
                    $comments[$index]['replies'][$index2]['replies'][$index3]['blog_id'] = $reply3->blog_id;
                    $comments[$index]['replies'][$index2]['replies'][$index3]['entry_id'] = $reply3->entry_id;
                    $comments[$index]['replies'][$index2]['replies'][$index3]['reply_id'] = $reply3->reply_id;
                    $comments[$index]['replies'][$index2]['replies'][$index3]['content'] = $reply3->content;
                    $comments[$index]['replies'][$index2]['replies'][$index3]['created_at'] = $reply3->created_at->format('l jS \\of F Y \a\t h:i A');
                    $comments[$index]['replies'][$index2]['replies'][$index3]['nickname'] = $reply3->user->nickname;
                    $comments[$index]['replies'][$index2]['replies'][$index3]['avatar_url'] = $reply3->user->profile->avatar_url;
                    $comments[$index]['replies'][$index2]['replies'][$index3]['deleted'] = $reply3->trashed();
                }
            }
        }
        return \Response::json($comments);
    }

    public function store(CreateEntryReplyRequest $request)
    {
        EntryReply::create($request->all());
        return \Response::json(array('success' => true));
    }

    public function update($id, CreateEntryReplyRequest $request)
    {
        $reply = EntryReply::find($id);
        $reply->fill($request->all());
        $reply->save();
        return \Response::json(array('success' => true));
    }

    public function destroy($id)
    {
        $reply = EntryReply::withTrashed()->find($id);
        if ($reply->trashed())
        {
            $reply->restore();
        } else EntryReply::destroy($id);
        return \Response::json(array('success' => true));
    }
}
