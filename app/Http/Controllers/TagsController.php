<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;

class TagsController extends Controller
{
    public function index($title)
    {
        return view('forum.thread.create', [
            'tags' => Tag::where('title', '=', $title)->get(),
        ]);
    }

    public static function getTags($tags_string)
    {
        $array = explode(',', strtolower($tags_string));
        $tags = array();
        foreach($array as $element)
        {
            if (trim($element) != "")
            {
                array_push($tags, trim($element));
            }
        }
        return $tags;
    }

    public static function createTagsFromThread($tags_string, $id)
    {
        foreach (TagsController::getTags($tags_string) as $tag)
        {
            Tag::create([
                'title' => $tag,
                'thread_id' => $id,
            ]);
        }
    }

    public static function createTagsFromEntry($tags_string, $id)
    {
        foreach (TagsController::getTags($tags_string) as $tag)
        {
            Tag::create([
                'title' => $tag,
                'entry_id' => $id,
            ]);
        }
    }

    public static function createTagsFromAttachment($tags_string, $id)
    {
        foreach (TagsController::getTags($tags_string) as $tag)
        {
            Tag::create([
                'title' => $tag,
                'attachment_id' => $id,
            ]);
        }
    }

    public static function implodeTags(Collection $tags)
    {
        return strtolower(implode(',', $tags->pluck('title')->toArray()));
    }
}
