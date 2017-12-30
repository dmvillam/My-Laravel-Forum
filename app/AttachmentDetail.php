<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttachmentDetail extends Model
{
    use SoftDeletes;

    protected $table = 'attachment_details';

    protected $fillable = ['attachment_id', 'desc', 'featured', 'pinned', 'locked'];

    public $timestamps = false;

    /*
     * Relations
     */
    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }

    /*
     * Custom Attributes
     */
    public function getCleanDescAttribute()
    {
        return nl2br(e($this->desc));
    }
}
