<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name', 'order'];

    public function boards()
    {
        return $this->hasMany(Board::class);
    }
}
