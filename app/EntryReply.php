<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntryReply extends Model
{
    use SoftDeletes;

    protected $table = 'entry_replies';

    protected $fillable = ['user_id', 'blog_id', 'entry_id', 'reply_id', 'content'];

    protected $dates = ['deleted_at'];

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

    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }
}
