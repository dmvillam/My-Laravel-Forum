<?php namespace App\Http\Controllers\PersonalMessages;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateConversationRequest;
use App\PersonalMessage;
use App\PmAlert;
use App\PmConversation;
use App\PmFolder;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class PmConversationsController extends Controller
{
    public function store(CreateConversationRequest $request)
    {
        if($request->subject == "") {
            $request['subject'] = "(Sin asunto)";
        }

        $dest_users = $this->getDestUsersById(
            $request->dest_users,
            User::get(['id','nickname'])->toArray(),
            User::find($request->user_id)
        );

        $conversation = PmConversation::create($request->all());
        $pm = $conversation->messages()->create($request->all());

        foreach ($dest_users as $user_id)
        {
            $conversation->users()->attach($user_id);
            $conversation->folders()->attach(User::find($user_id)->folders->first()->id);
            $pm->folders()->attach(User::find($user_id)->folders->first()->id);
            if ($user_id != \Auth::user()->id)
                PmAlert::create(['user_id' => $user_id, 'pm_conversation_id' => $conversation->id]);
        }
        return \Redirect::route('users.pm.index');
    }

    public function reply(CreateConversationRequest $request, $folder_id, $conversation_id)
    {
        $pm = PmConversation::find($conversation_id)->messages()->create($request->all());

        $attach_folders = array();
        foreach(PmConversation::find($conversation_id)->users as $user)
        {
            array_push($attach_folders, $user->folders->first()->id);
            if ($user->id != \Auth::user()->id)
            {
                $alert = $user->pm_alerts()->where('pm_conversation_id', '=', $conversation_id)->first();
                if ($alert == null)
                {
                    PmAlert::create(['user_id' => $user->id, 'pm_conversation_id' => $conversation_id]);
                }
                else
                {
                    $alert->is_read = 0;
                    $alert->save();
                }
            }
        }
        $pm->folders()->attach($attach_folders);

        return \Redirect::route('users.pm.conversation', [$folder_id, $conversation_id]);
    }

    public function destroy($folder_id, $conversation_id)
    {
        PmFolder::find($folder_id)->conversations()->detach($conversation_id);
        \Auth::user()->conversations()->detach($conversation_id);
        foreach(PersonalMessage::where('pm_conversation_id', '=', $conversation_id)->get() as $pm)
        {
            PmFolder::find($folder_id)->messages()->detach($pm->id);
        }
        if (count(PmConversation::find($conversation_id)->users) === 0)
        {
            foreach(PersonalMessage::where('pm_conversation_id', '=', $conversation_id)->get() as $pm)
            {
                $pm->delete();
            }
            PmConversation::find($conversation_id)->delete();
        }
        return \Redirect::route('users.pm.index');
    }

    private function getDestUsersById($dest_users_string, $available_users, $starter_user)
    {
        $array = explode(',', $dest_users_string);
        $requested_users = array();
        foreach($array as $element)
        {
            if (trim($element) != "")
            {
                array_push($requested_users, trim($element));
            }
        }
        // Agregando al iniciador de la conversación en la lista de destinatarios
        // existe la posibilidad de que el usuario al llenar el formulario ya lo haya hecho,
        // pero no creará conflicto si se repite, ya que en el siguiente paso los repetidos
        // son desechados
        array_push($requested_users, $starter_user->nickname);

        $dest_users = array();
        foreach ($available_users as $user)
        {
            foreach ($requested_users as $requested)
            {
                if ($user['nickname'] == $requested)
                {
                    array_push($dest_users, $user['id']);
                    break;
                }
            }
        }
        return $dest_users;
    }
}
