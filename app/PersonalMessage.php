<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalMessage extends Model
{
    protected $table = 'personal_messages';

    protected $fillable = ['content', 'user_id', 'pm_conversation_id'];

    /*
     * Relations
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function folders()
    {
        return $this->belongsToMany(PmFolder::class);
    }

    public function conversation()
    {
        return $this->belongsTo(PmConversation::class);
    }
}
