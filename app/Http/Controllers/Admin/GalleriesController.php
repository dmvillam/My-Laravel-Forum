<?php namespace App\Http\Controllers\Admin;

use App\Gallery;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGalleryRequest;
use Illuminate\Http\Request;

use App\Http\Requests;

class GalleriesController extends Controller
{
    public function index()
    {
        $galleries = ['(ninguna)'];
        foreach (Gallery::all() as $gallery)
        {
            $galleries[$gallery->id] = $gallery->title;
        }

        return view('admin.galleries.index', [
            'galleries' => Gallery::orderBy('order', 'ASC')->get(),
            'c_childs' => $galleries,
        ]);
    }

    public function store(CreateGalleryRequest $request)
    {
        $galleries = count(Gallery::where('child_of', '=', $request->child_of)->get());
        if ($galleries > 0)
        {
            $request['order'] = $galleries;
        }
        else $request['order'] = 0;
        Gallery::create($request->all());
        return \Redirect::route('admin.galleries.index');
    }

    public function update($id, CreateGalleryRequest $request)
    {
        $gallery = Gallery::find($id);
        if ($request->child_of != $gallery->child_of)
        {
            $this->removeElementFromGroup($id);
            $request['order'] = $this->moveElementToNewGroup($id, Gallery::where('child_of', '=', $request->child_of)->get());
        }
        $gallery->fill($request->all());
        $gallery->save();
        return \Redirect::route('admin.galleries.index');
    }

    public function up($id)
    {
        $gallery = Gallery::find($id);
        if ($gallery->order != 0)
        {
            $gallery_prev = Gallery::where('child_of', '=', $gallery->child_of)
                ->where('order', '=', $gallery->order - 1)->get()->first();
            $dummy = $gallery_prev->order;
            $gallery_prev['order'] = $gallery->order;
            $gallery['order'] = $dummy;
            $gallery->save();
            $gallery_prev->save();
        }
        return \Redirect::route('admin.galleries.index');
    }

    public function down($id)
    {
        $gallery = Gallery::find($id);
        $last_gallery = Gallery::where('child_of', '=', $gallery->child_of)
            ->orderBy('order', 'ASC')
            ->get()
            ->last();
        if ($gallery->order != $last_gallery->order)
        {
            $gallery_next = Gallery::where('child_of', '=', $gallery->child_of)
                ->where('order', '=', $gallery->order + 1)->get()->first();
            $dummy = $gallery_next->order;
            $gallery_next['order'] = $gallery->order;
            $gallery['order'] = $dummy;
            $gallery->save();
            $gallery_next->save();
        }
        return \Redirect::route('admin.galleries.index');
    }

    public function destroy($id)
    {
        $this->removeElementFromGroup($id);
        Gallery::destroy($id);
        return \Redirect::route('admin.galleries.index');
    }

    private function removeElementFromGroup($id)
    {
        $destroyed_element = Gallery::find($id);
        $element_group = $destroyed_element->child_of;
        foreach (Gallery::where('child_of', '=', $element_group)->get() as $gallery)
        {
            if ($gallery->order > $destroyed_element->order)
            {
                $gallery['order'] = $gallery->order - 1;
                $gallery->save();
            }
        }
    }

    private function moveElementToNewGroup($id, $new_group)
    {
        $galleries = count($new_group);
        if ($galleries > 0)
        {
            $new_order = $galleries;
        }
        else $new_order = 0;
        return $new_order;
    }
}
