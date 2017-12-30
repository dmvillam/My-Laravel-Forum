<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'attachments';
    protected $fillable = ['user_id', 'gallery_id', 'file_name', 'original_name', 'hash', 'ext', 'size', 'downloads', 'width', 'height', 'mime_type', 'approved'];

    /*
     * Relations
     */
    public function details()
    {
        return $this->hasOne(AttachmentDetail::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(GalleryComment::class);
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
     * Scopes
     */
    public function scopeTag($query, $tag)
    {
        if (trim($tag) != "")
        {
            $query->whereHas('tags', function ($query) use ($tag) {
                $query->where('title', '=', $tag);
            });
        }
    }

    public function scopeTagsarray($query, $tags_string)
    {
        foreach(explode(',', $tags_string) as $tag)
        {
            $query->tag($tag);
        }
    }
}
