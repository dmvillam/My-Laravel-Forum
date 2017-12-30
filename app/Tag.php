<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['title', 'thread_id', 'entry_id', 'attachment_id'];
    public $timestamps = false;

    /*
     * Relations
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }

    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }
}
