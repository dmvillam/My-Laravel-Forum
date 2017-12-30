<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $touches = array('thread');

    protected $fillable = ['title', 'content', 'category_id', 'board_id', 'thread_id', 'user_id', 'reply_id'];

    /*
     * Relations
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
     * Scopes
     */
    public function scopeSearchText($query, $search_text)
    {
        if (trim($search_text) != "")
        {
            $query->where('content', "LIKE", "%$search_text%");
        }
    }

    public function scopeGetThread($query, $thread_id)
    {
        if (trim($thread_id) != "")
        {
            $query->where('thread_id', '=', $thread_id);
        }
    }

    public function scopeGetBoard($query, $board_id)
    {
        if (trim($board_id) != "")
        {
            $query->where('board_id', '=', $board_id);
        }
    }

    public function scopeGetCategory($query, $category_id)
    {
        if (trim($category_id) != "")
        {
            $query->where('category_id', '=', $category_id);
        }
    }

    public function scopeGetUser($query, $user_id)
    {
        if (trim($user_id) != "")
        {
            $query->where('user_id', '=', $user_id);
        }
    }

    public function scopeIsOP($query, $op)
    {
        if ($op == "1" || $op == "y")
        {
            $query->where('reply_id', '=', 0);
        }
    }

    /*
     * Custom Attributes
     */
    public function getCleanContentAttribute()
    {
        return nl2br(e($this->content));
    }

    /*
     * Custom Methods
     */
    public function deleteAllFromThread($thread_id)
    {
        $thread = Thread::find($thread_id);
        foreach ($thread->posts as $post)
        {
            $post->destroy();
        }
    }
}
