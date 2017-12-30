<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileComment extends Model
{
    protected $table = 'profile_comments';

    protected $fillable = ['content', 'reply_level', 'user_id', 'user_profile_id', 'profile_comment_id'];

    /*
     * Relations
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profile()
    {
        return $this->belongsTo(UserProfile::class);
    }

    public function replies()
    {
        return $this->hasMany(ProfileComment::class);
    }

    public function replyingTo()
    {
        return $this->belongsTo(ProfileComment::class);
    }

    /*
    * Custom Attributes
    */
    public function getCleanContentAttribute()
    {
        return nl2br(e($this->content));
    }
}
