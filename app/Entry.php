<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $table = 'entries';

    protected $fillable = ['user_id', 'blog_id', 'pic', 'title', 'content'];

    /*
     * Relations
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function replies()
    {
        return $this->hasMany(EntryReply::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    /*
     * Custom Attributes
     */
    public function getCleanContentAttribute()
    {
        return nl2br(e($this->content));
    }

    public function getFragmentedContentAttribute()
    {
        return implode(' ', array_slice(explode(' ', $this->clean_content), 0, 30));
    }

    public function getPicUrlAttribute()
    {
        if ($this->pic != null)
        {
            return url('/') . '/attachments/' . $this->pic;
        }
        else
        {
            return url('/') . '/logos/default.png';
        }
    }
}
