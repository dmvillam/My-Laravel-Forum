<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PmFolder extends Model
{
    protected $table = 'pm_folders';

    protected $fillable = ['folder_name', 'folder_desc', 'user_id'];

    /*
     * Relations
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->belongsToMany(PersonalMessage::class);
    }

    public function conversations()
    {
        return $this->belongsToMany(PmConversation::class);
    }
}
