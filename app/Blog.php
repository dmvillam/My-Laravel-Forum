<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';

    protected $fillable = ['user_id', 'name', 'desc', 'banner'];

    /*
     * Relations
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function replies()
    {
        return $this->hasMany(EntryReply::class);
    }

    /*
     * Custom Attributes
     */
    public function getBannerUrlAttribute()
    {
        if ($this->banner != null)
        {
            return url('/') . '/attachments/' . $this->banner;
        }
        else
        {
            return null;
        }
    }
}
