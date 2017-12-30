<?php namespace App\Http\Controllers\Blogs;

use App\Blog;
use App\Entry;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TagsController;
use App\Http\Requests\CreateEntryRequest;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;

class EntriesController extends Controller
{
    public function create($blog_id)
    {
        return view('blogs.entry.create', ['blog' => Blog::find($blog_id)]);
    }

    public function store(CreateEntryRequest $request)
    {
        $entry = Entry::create($request->all());

        if ($request->pic != null) {
            $imgName = 'entry' . $entry->id . '.' . $request->file('pic')->getClientOriginalExtension();
            $request->file('pic')->move(
                public_path() . '/attachments/', $imgName
            );
            $entry->fill(['pic' => $imgName]);
            $entry->save();
        }

        TagsController::createTagsFromEntry($request['tags'], $entry->id);

        return \Redirect::route('blogs.show', [$request->blog_id]);
    }

    public function show($blog_id, $entry_id)
    {
        $entry = Entry::find($entry_id);
        $weekdays = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
        return view('blogs.entry.index', [
            'entry' => $entry,
            'date' => $entry->created_at->format('d/M/Y'),
            'time' => $entry->created_at->format('g:i A'),
            'weekday' => ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'][$entry->created_at->format('w')],
        ]);
    }

    public function edit($blog_id, $entry_id)
    {
        $entry = Entry::find($entry_id);
        $entry['tags'] = TagsController::implodeTags($entry->tags);
        return view('blogs.entry.edit', [
            'entry' => $entry,
        ]);
    }

    public function update($blog_id, $entry_id, CreateEntryRequest $request)
    {
        $entry = Entry::find($entry_id);
        $entry->fill($request->all());
        if ($request->pic != null) {
            $imgName = 'entry' . $entry->id . '.' . $request->file('pic')->getClientOriginalExtension();
            $request->file('pic')->move(
                public_path() . '/attachments/', $imgName
            );
            $entry->fill(['pic' => $imgName]);
        }
        $entry->save();

        Tag::where('entry_id', '=', $entry_id)->delete();
        TagsController::createTagsFromEntry($request['tags'], $entry_id);

        return \Redirect::route('blogs.entry.show', [$blog_id, $entry_id]);
    }

    public function destroy($blog_id, $entry_id)
    {
        Entry::destroy($entry_id);
        /* //To do: destroy entry comments
        foreach (Entry::where('blog_id', '=', $id)->get() as $entry)
        {
            $entry->delete();
        }*/
        return \Redirect::route('blogs.show', [Blog::find($blog_id)]);
    }
}
