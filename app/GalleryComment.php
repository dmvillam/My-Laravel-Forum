<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryComment extends Model
{
    use SoftDeletes;

    protected $table = 'gallery_comments';

    protected $fillable = ['user_id', 'gallery_id', 'attachment_id', 'reply_id', 'content'];

    protected $dates = ['deleted_at'];

    /*
     * Relations
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }

    /*
     * Custom Attributes
     */
    public function getCleanContentAttribute()
    {
        return nl2br(e($this->content));
    }
}
