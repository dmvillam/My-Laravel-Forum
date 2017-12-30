<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $table = 'boards';

    protected $fillable = ['name', 'desc', 'logo', 'order', 'category_id', 'board_id'];

    /*
     * Relations
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /*
     * Custom Attributes
     */
    public function getLogoUrlAttribute()
    {
        $logo_filename = ($this->logo == null) ? 'default.png' : $this->logo;
        return url('/') . '/logos/' . $logo_filename;
    }

    public function ImgLogo($maxwidth=60,$maxheight=60,$array=['class' => 'img-rounded', 'title' => ''])
    {
        return '<img
                        src="' . $this->logo_url . '"
                        class="' . $array['class'] . '"
                        title="' . $array['title'] . '"
                        style="max-width: ' . $maxwidth . 'px; max-height: ' . $maxheight . 'px;">';
    }
}
