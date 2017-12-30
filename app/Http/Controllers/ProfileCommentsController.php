<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProfileCommentRequest;
use App\ProfileComment;
use App\User;
use App\UserProfile;
use Illuminate\Http\Request;

use App\Http\Requests;

class ProfileCommentsController extends Controller
{
    public function store(EditProfileCommentRequest $request, $user_id)
    {
        $request['user_id'] = $request->user()->id;
        if ($request->reply_level > 1)
        {
            $request['profile_comment_id'] = $request->profile_comment_id;
        }
        User::find($user_id)->profile->comments()->create($request->all());

        return \Redirect::route('users.profile', ['user' => User::find($user_id)]);
    }

    public function update(EditProfileCommentRequest $request, $user_id, $comment_id)
    {
        $comment = ProfileComment::find($comment_id);
        $comment->fill($request->all());
        $comment->save();
        return redirect()->route('users.profile', ['user' => User::find($user_id)]);
    }

    public function destroy(Request $request, $user_id, $comment_id)
    {
        ProfileComment::destroy($comment_id);
        $child_comments = ProfileComment::where('profile_comment_id', '=', $comment_id)->get();
        foreach ($child_comments as $comment)
        {
            $comment->delete();
        }
        return redirect()->route('users.profile', ['user' => User::find($user_id)]);
    }
}
