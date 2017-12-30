<?php namespace App\Http\Controllers;

use App\Http\Requests\EditAvatarRequest;
use App\Http\Requests\EditProfileImgRequest;
use App\Http\Requests\EditProfileRequest;
use App\Post;
use App\Thread;
use App\User as User;
use App\UserProfile;

class UsersController extends Controller
{
    public function getOrm()
    {
        $users = User::select('id', 'name', 'email', 'type')
            ->with('profile')
            ->get();
        dd($users->toArray());
    }

    public function getIndex()
    {
        $users = \DB::table('users')
            ->select(
                'users.id', 'name', 'email', 'type',
                'user_profiles.user_id',
                'user_profiles.id as profile_id',
                'bio', 'twitter', 'website', 'birthdate'
            )
            //->where('name', '<>', 'Hielitos Ivis')
            ->orderBy('name', 'ASC')
            ->leftJoin('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->get();

        foreach($users as $user)
        {
            $user->age = \Carbon\Carbon::parse($user->birthdate)->age;
        }

        dd($users);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param User $user
     */
    public function show($id)
    {
        $user = User::find($id);

        //TODO: verify if $user is not null or develop 'error, user not found' view

        return view('users.profile', ['user' => $user]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('users.edit', ['user' => User::find($id)]);
    }

    /**
     * @param EditProfileRequest $request
     * @param $id
     * @return mixed
     */
    public function update(EditProfileRequest $request, $id)
    {
        $profile = UserProfile::find($id);

        $profile->fill($request->all());
        $profile->save();

        \Session::flash('message', 'El perfil del usuario <strong>' . $profile->user->nickname . '</strong> ha sido editado!');
        return redirect('users/' . $id);
    }

    public function avataredit($id)
    {
        return view('users.avatar.edit', ['user' => User::find($id)]);
    }

    public function avatarupdate(EditAvatarRequest $request, $id)
    {
        $profile = UserProfile::find($id);

        $imageName = $profile->id . '.' .
            $request->file('avatar')->getClientOriginalExtension();

        $request->file('avatar')->move(
            public_path() . '/avatars/', $imageName
        );

        $profile->fill(['avatar' => $imageName]);
        $profile->save();

        \Session::flash('message', 'El avatar del usuario <strong>' . $profile->user->nickname . '</strong> ha sido actualizado!');
        return redirect('users/' . $id);
    }

    public function profileImgUpdate(EditProfileImgRequest $request, $id)
    {
        $profile = UserProfile::find($id);

        $imageName = 'profile_img_' . $profile->id . '.' .
            $request->file('profile_img')->getClientOriginalExtension();

        $request->file('profile_img')->move(
            public_path() . '/attachments/', $imageName
        );

        $profile->fill(['profile_img' => $imageName]);
        $profile->save();
        return redirect('users/' . $id);
    }

    public function threadsShow($id)
    {
        $user = User::find($id);
        return view('users.threads_list_index', [
            'user' => $user,
            'threads' => Thread::where('user_id', '=', $user->id)->orderBy('created_at', 'DESC')->paginate(10),
        ]);
    }

    public function postsShow($id)
    {
        $user = User::find($id);
        return view('users.posts_list_index', [
            'user' => $user,
            'posts' => Post::where('user_id', '=', $user->id)->orderBy('created_at', 'DESC')->paginate(10),
        ]);
    }
}