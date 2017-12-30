<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galleries';
    protected $fillable = ['title', 'desc', 'order', 'child_of'];
    public $timestamps = false;

    /*
     * Relations
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function comments()
    {
        return $this->hasMany(GalleryComment::class);
    }
}
