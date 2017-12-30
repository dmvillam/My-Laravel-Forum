<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PmAlert extends Model
{
    protected $table = 'pm_alerts';

    protected $fillable = ['user_id', 'pm_conversation_id', 'is_read'];

    /*
     * Relations
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conversation()
    {
        return $this->belongsTo(PmConversation::class);
    }
}
