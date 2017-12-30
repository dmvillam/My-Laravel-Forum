<?php namespace App\Http\Controllers\PersonalMessages;

use App\Http\Controllers\Controller;
use App\PmConversation;
use App\PmFolder;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class PersonalMessagesController extends Controller
{
    public function index($folderId = 0)
    {
        if ($folderId != 0)
        {
            if (\Auth::user()->folders()->find($folderId) == null)
            {
                return \Redirect::route('users.pm.index');
            }
            else return view('pm.index', [
                'folder_id' => $folderId,
            ]);
        }
        else return view('pm.index', [
            'folder_id' => \Auth::user()->folders->first()->id,
        ]);
    }

    public function conversation_index($folderId, $conversationId)
    {
        $alert = \Auth::user()->pm_alerts()->where('pm_conversation_id', '=', $conversationId)->first();
        if ($alert != null)
        {
            $alert->is_read = 1;
            $alert->save();
        }
        return view('pm.conversations.index', [
            'folder_id' => $folderId,
            'folder' => PmFolder::find($folderId),
            'conversation' => PmConversation::find($conversationId),
        ]);
    }
}
