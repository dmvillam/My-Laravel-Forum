<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = ['website', 'twitter', 'bio', 'country_id', 'avatar', 'profile_img', 'signature', 'gender'];

    /*
     * Relations
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(ProfileComment::class);
    }

    /*
     * Custom Attributes
     */
	public function getAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->birthdate)->age;
    }

    public function getCountryAttribute()
    {
        $country = array_merge([''], config('countries.list'));
        return $country[$this->country_id];
    }

    public function getAvatarUrlAttribute()
    {
        $avatar_filename = ($this->avatar == null) ? 'default.png' : $this->avatar;
        return url('/') . '/avatars/' . $avatar_filename;
    }

    public function ImgAvatar($maxwidth=150,$maxheight=150,$class='img-circle',$title='')
    {
        return '<img
                        src="' . $this->avatar_url . '"
                        class="' . $class . '"
                        title="' . $title . '"
                        style="max-width: ' . $maxwidth . 'px; max-height: ' . $maxheight . 'px;">';
    }

    public function getImgUrlAttribute()
    {
        $profile_img_url = url('/') . '/attachments/' . $this->profile_img;
        return ($this->profile_img == null) ? '' : $profile_img_url;
    }

    public function getCleanSignatureAttribute()
    {
        return nl2br(e($this->signature));
    }

    public function getTextGenderAttribute()
    {
        return ['none' => 'N/A', 'male' => 'Masculino', 'female' => 'Femenino'][$this->gender];
    }

    public function getIconGenderAttribute()
    {
        return [
            'none' => '',
            'male' => '<i class="fa fa-mars" aria-hidden="true"></i>',
            'female' => '<i class="fa fa-venus" aria-hidden="true"></i>'
        ][$this->gender];
    }
}
