<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PmConversation extends Model
{
    protected $table = 'pm_conversations';

    protected $fillable = ['subject'];

    /*
     * Relations
     */
    public function folders()
    {
        return $this->belongsToMany(PmFolder::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function messages()
    {
        return $this->hasMany(PersonalMessage::class);
    }

    public function conversations()
    {
        return $this->hasMany(PmConversation::class);
    }

    public function pm_alert()
    {
        return $this->hasOne(PmAlert::class);
    }
}
