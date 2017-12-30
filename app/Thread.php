<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $table = 'threads';

    protected $fillable = ['title', 'locked', 'sticky', 'category_id', 'board_id', 'user_id'];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    /*
     * Custom Attributes
     */
    public function getShortTitleAttribute()
    {
        $max_words = 6;
        if (count(explode(' ', $this->title)) > $max_words)
        {
            $short_title = implode(' ', array_slice(explode(' ', $this->title), 0, $max_words)) . "...";
            return $short_title;
        }
        else
        {
            return $this->title;
        }
    }
}
