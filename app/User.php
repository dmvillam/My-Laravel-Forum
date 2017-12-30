<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['firstname', 'lastname', 'fullname', 'nickname', 'email', 'password', 'type'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    /*
     * Relations
     */
	public function profile()
	{
		return $this->hasOne(UserProfile::class);
	}

	public function tasks()
	{
		return $this->hasMany(Task::class);
	}

	public function threads()
	{
		return $this->hasMany(Thread::class);
	}

	public function posts()
	{
		return $this->hasMany(Post::class);
	}

	public function comments()
	{
		return $this->hasMany(ProfileComment::class);
	}

	public function message()
	{
		return $this->hasOne(PersonalMessage::class);
	}

	public function folders()
	{
		return $this->hasMany(PmFolder::class);
	}

    public function conversations()
    {
        return $this->belongsToMany(PmConversation::class);
    }

	public function pm_alerts()
    {
        return $this->hasMany(PmAlert::class);
    }

	public function blogs()
	{
		return $this->hasMany(Blog::class);
	}

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function entry_replies()
    {
        return $this->hasMany(EntryReply::class);
    }

	public function attachments()
	{
		return $this->hasMany(Attachment::class);
	}

	public function gallery_comments()
	{
		return $this->hasMany(GalleryComment::class);
	}

    /*
     * Custom Attributes
     */
	public function setPasswordAttribute($value)
	{
        if (!empty($value))
        {
            $this->attributes['password'] = \Hash::make($value);
        }
	}

    /*
     * Scopes
     */
    public function scopeFullname($query, $fullname)
    {
        if (trim($fullname) != "")
        {
            $query->where('fullname', "LIKE", "%$fullname%");
        }
    }

    public function scopeNickname($query, $nickname)
    {
        if (trim($nickname) != "")
        {
            $query->where('nickname', "LIKE", "%$nickname%");
        }
    }

    public function scopeEmail($query, $email)
    {
        if (trim($email) != "")
        {
            $query->where('email', "LIKE", "%$email%");
        }
    }

    public function scopeType($query, $type)
	{
		$types = config('options.types');

		if ($type != "" && isset($types[$type]))
		{
			$query->where('type', '=', $type);
		}
	}

	/**
	 * @param $fullname
	 * @param $type
	 * @param $orderby
	 * @return mixed
     */
	public static function filterAndPaginate($fullname, $type, $orderby)
    {
        $types_orderby = array('id' => 'id', 'name' => 'fullname', 'email' => 'email', 'type' => 'type');
        $order = $orderby != "" && isset($types_orderby[$orderby]) ? $types_orderby[$orderby] : 'id';

        return User::fullname($fullname)
            ->type($type)
            ->orderBy($order, 'ASC')
            ->paginate();
    }

    public function IsAdmin()
    {
        return $this->type === 'admin';
    }
}
