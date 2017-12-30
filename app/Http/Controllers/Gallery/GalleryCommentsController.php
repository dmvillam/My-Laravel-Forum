<?php namespace App\Http\Controllers\Gallery;

use App\GalleryComment;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGalleryCommentRequest;
use App\Http\Requests\EditGalleryCommentRequest;
use Illuminate\Http\Request;

use App\Http\Requests;

class GalleryCommentsController extends Controller
{
    public function store(CreateGalleryCommentRequest $request)
    {
        $comment = GalleryComment::create($request->all());
        return \Response::json([
            'user_avatar_url' => $comment->user->profile->avatar_url,
            'user_profile_url' => url('/') . '/users/' . $comment->user->id,
            'user_nickname' => $comment->user->nickname,
            'created_at' => $this->getSpanishFormatFromDate($comment->created_at),
            'my_content' => $comment->content,
        ]);
    }

    public function update($id, EditGalleryCommentRequest $request)
    {
        $comment = GalleryComment::find($id);
        $comment->fill([
            'user_id' => $comment->user_id,
            'gallery_id' => $comment->gallery_id,
            'attachment_id' => $comment->attachment_id,
            'reply_id' => $comment->reply_id,
            'content' => $request['content'],
        ]);
        $comment->save();
        return \Response::json(array('my_content' => $comment->content));
    }

    public function destroy($id)
    {
        $comment = GalleryComment::withTrashed()->find($id);
        if ($comment->trashed())
        {
            $comment->restore();
        } else GalleryComment::destroy($id);

        return \Response::json(array(
            'id' => $id,
            'user_avatar_url' => $comment->user->profile->avatar_url,
            'user_profile_url' => url('/') . '/users/' . $comment->user->id,
            'user_nickname' => $comment->user->nickname,
            'created_at' => $this->getSpanishFormatFromDate($comment->created_at),
            'my_content' => $comment->content,
        ));
    }

    private function getSpanishFormatFromDate($date)
    {
        $weekday = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'][$date->format('w')];
        $day = $date->format('j');
        $month = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'][$date->format('n') - 1];
        $year = $date->format('Y');
        return $weekday . ', ' . $day . ' de ' . $month . ' del ' . $year;
    }
}
