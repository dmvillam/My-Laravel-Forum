<?php namespace App\Http\Controllers\Gallery;

use App\Attachment;
use App\Gallery;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TagsController;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;

class GalleriesController extends Controller
{
    public function index(Request $request, $id = 0)
    {
        $g_select = array();
        foreach (Gallery::where('child_of', '=', 0)->get() as $index => $gallery)
        {
            $g_select[$gallery->id] = $gallery->title;
            $g_select = $this->iterateGSelect($g_select, Gallery::where('child_of', '=', $gallery->id)->get(), 1);
        }
        if ($request->get('tags') != null)
        {
            $attachments = Attachment::tagsarray($request->get('tags'))
                ->orderBy('created_at', 'DESC')
                ->paginate();
        }
        else
        {
            if ($id == 0)
                $attachments = Attachment::orderBy('created_at', 'DESC')->paginate();
            else $attachments = Attachment::where('gallery_id', '=', $id)->orderBy('created_at', 'DESC')->paginate();
        }

        $tags = [];
        foreach($attachments as $attachment)
        {
            $tags = array_unique(array_merge($tags, explode(',', TagsController::implodeTags($attachment->tags))));
        }
        asort($tags);

        return view('galleries.index', [
            'gallery' => Gallery::find($id),
            'galleries' => Gallery::where('child_of', '=', $id)->get(),
            'attachments' => $attachments,
            'g_select' => $g_select,
            'tags' => $tags,
            'request_tags' => $request->get('tags'),
        ]);
    }

    private function iterateGSelect($g_select, $galleries_group, $level)
    {
        foreach ($galleries_group as $index => $gallery)
        {
            $g_select[$gallery->id] = "";
            for ($i = 0; $i < $level; $i++)
            {
                $g_select[$gallery->id] .= "&nbsp;&nbsp;&nbsp;&nbsp;";
            }
            $g_select[$gallery->id] .= $gallery->title;
            $g_select = $this->iterateGSelect($g_select, Gallery::where('child_of', '=', $gallery->id)->get(), $level + 1);
        }
        return $g_select;
    }
}
