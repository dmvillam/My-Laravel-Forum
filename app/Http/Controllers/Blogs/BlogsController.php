<?php namespace App\Http\Controllers\Blogs;

use App\Blog;
use App\Entry;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\CreateEntryRequest;

use App\Http\Requests;

class BlogsController extends Controller
{
    public function index()
    {
        return view('blogs.index', [
            'entries' => Entry::all(),
            'blogs' => Blog::all(),
        ]);
    }

    public function create()
    {
        return view('blogs.create');
    }

    public function store(CreateBlogRequest $request)
    {
        $blog = Blog::create($request->all());

        if ($request->banner != null) {
            $imgName = 'blog' . $blog->id . '.' . $request->file('banner')->getClientOriginalExtension();
            $request->file('banner')->move(
                public_path() . '/attachments/', $imgName
            );
            $blog->fill(['banner' => $imgName]);
            $blog->save();
        }

        return \Redirect::route('blogs.index');
    }

    public function edit($id)
    {
        return view('blogs.edit', ['blog' => Blog::find($id)]);
    }

    public function update($id, CreateBlogRequest $request)
    {
        $blog = Blog::find($id);
        $blog->fill($request->all());
        $blog->save();
        return \Redirect::route('blogs.show', [$id]);
    }

    public function show($id)
    {
        $blog = Blog::find($id);
        $replies_count = 0;
        foreach ($blog->entries as $entry)
        {
            $replies_count += count($entry->replies);
        }
        return view('blogs.blog.index', [
            'blog' => $blog,
            'replies_count' => $replies_count,
        ]);
    }

    public function destroy($id)
    {
        Blog::destroy($id);
        foreach (Entry::where('blog_id', '=', $id)->get() as $entry)
        {
            $entry->delete();
        }
        return \Redirect::route('blogs.index');
    }
}
