<?php namespace App\Http\Controllers\Gallery;

use App\Attachment;
use App\AttachmentDetail;
use App\GalleryComment;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TagsController;
use App\Http\Requests\CreateAttachmentRequest;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;

class AttachmentsController extends Controller
{
    public function index($id)
    {
        $attachment = Attachment::find($id);
        $tags = $attachment->tags->pluck('title')->toArray();
        asort($tags);
        return view('galleries.attachments.index', [
            'attachment' => $attachment,
            'comments' => GalleryComment::withTrashed()
                ->where('attachment_id', '=', $id)
                ->get(),
            'tags' => $tags,
        ]);
    }

    public function store(CreateAttachmentRequest $request)
    {
        list($width, $height, $type, $attr) = getimagesize($request->file('pic')->getPathName());
        $file_hash = md5_file($request->file('pic')->getPathName());
        $fileName = $file_hash . '.' . $request->file('pic')->getClientOriginalExtension();
        $ibFileName = time() . substr(microtime(), 2, 3);
        $request->file('pic')->move(public_path() . '/attachments/', $fileName);
        $attachment = Attachment::create([
            'user_id' => $request->user_id,
            'gallery_id' => $request->gallery_id,
            'file_name' => $fileName,
            'original_name' => $request->file('pic')->getClientOriginalName(),
            'hash' => $file_hash,
            'ext' => $request->file('pic')->getClientOriginalExtension(),
            'size' => $request->file('pic')->getClientSize(),
            'downloads' => 0,
            'width' => $width,
            'height' => $height,
            'mime_type' => $request->file('pic')->getClientMimeType(),
            'approved' => false,
        ]);
        $attch_details = AttachmentDetail::create(['attachment_id' => $attachment->id]);
        return \Response::json($attachment);
    }

    public function show($id)
    {
        return \Response::json(Attachment::find($id));
    }

    public function edit($id)
    {
        $attachment = Attachment::find($id);
        $attachment->details['tags'] = TagsController::implodeTags($attachment->tags);
        return view('galleries.attachments.edit', ['attachment' => $attachment]);
    }

    public function update($id, Request $request)
    {
        unset($request['gallery_id'], $request['file_name'], $request['hash'], $request['ext'], $request['size'], $request['downloads'],
            $request['width'], $request['height'], $request['mime_type'], $request['approved'], $request['attachment_id']);

        $att = Attachment::find($id);
        $att->fill($request->all());
        $att->save();

        $att_details = $att->details;
        $att_details->fill($request->all());
        $att_details->save();

        Tag::where('attachment_id', '=', $id)->delete();
        TagsController::createTagsFromAttachment($request['tags'], $id);

        return \Redirect::route('gallery.attachments.index', $id);
    }

    public function destroy($id, Request $request)
    {
        $attachment = Attachment::find($id);
        $att_path = public_path() . '/attachments/' . $attachment->file_name;
        if (\File::exists($att_path))
            \File::delete($att_path);

        Attachment::destroy($id);

        AttachmentDetail::where('attachment_id', '=', $id)->forceDelete();
        Tag::where('attachment_id', '=', $id)->forceDelete();
        GalleryComment::where('attachment_id', '=', $id)->forceDelete();

        if ($request->ajax())
        {
            return \Response::json(['success' => true]);
        }
        else return \Redirect::route('galleries.index');
    }
}
