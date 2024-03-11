<?php

namespace App\Repositories\Chat;

use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class ChatRepository extends Controller implements ChatInterface
{
    private $chatModel;
    private $contactModel;

    public function __construct(Message $chatModel,Contact $contactModel)
    {
        $this->chatModel = $chatModel;
        $this->contactModel = $contactModel;
    }

    public function getById($id)
    {
        return $this->chatModel::find($id);
    }
    public function getContactById($id){
        return $this->contactModel::find($id);
    }

    public function store($request)
    {
        return $this->chatModel::create([
            'contact_id' => $request->contact->id,
            'sender_id' => $request->user->id,
            'receiver_id' => $request->receiver_id,
            'image_path' => @$request->media->path ? asset($request->media->path) : null,
            'message' => strip_tags(html_entity_decode($request->message)),
            'readed' => 0,
        ]);
    }

    public function update($request, $id)
    {
        // TODO: Implement update() method.
    }

    public function destroy($id)
    {
        try {
            $message = $this->chatModel::find($id);
            if ($message) {
                $message->delete();
            }
        } catch (Exception $exception) {
            return response()->json(['message' => __('message.server_error')], 500);
        }
    }

    public function getContactByUserId($id)
    {
        return Contact::where('user_id', $id)
            ->paginate(config('constants.DATA_PER_PAGE'));
    }

    public function getChatByUserAndReceiver($id)
    {
        $contact = Contact::find($id);
        $where = [
            ['sender_id', '=', $contact->user_id],
            ['receiver_id', '=', $contact->receiver_id]
        ];
        $orWhere = [
            ['sender_id', '=', $contact->receiver_id],
            ['receiver_id', '=', $contact->user_id]
        ];
        return $this->chatModel::where($where)->orWhere($orWhere)->orderBy('created_at', 'asc')->get();
    }

    public function push($receiver, $message)
    {
        event(new ChatEvent($receiver, $message));
    }

    public function firstOrNewContact($request)
    {
        $contact = Contact::firstOrNew(['id' => $request->contact_id]);
        $receiver_contact = Contact::firstOrNew(['user_id'=>$request->receiver_id]);
        $receiver = User::select('name')->where('id', $request->receiver_id)->first();
        if (!$contact->id) {
            $contact->fill([
                'receiver_id' => $contact->receiver_id ?? $request->receiver_id,
                'user_id' => $contact->user_id ?? $request->user->id,
                'receiver_name' => $receiver->name,
                'receiver_referral_code'=>$receiver->referral_code,
                'readed' => 0
            ]);
            if ($contact->image_path === null) {
                $contact->image_path = asset($contact->receiver->avatar);
            }
            $contact->save();
        }
        if (!$receiver_contact->id) {
            $receiver_contact->fill([
                'receiver_id' => $receiver_contact->receiver_id ?? $request->user->id,
                'user_id' => $receiver_contact->user_id ?? $request->receiver_id,
                'receiver_referral_code'=>$request->user->referral_code,
                'receiver_name' => $request->user->name,
                'readed' => 0
            ]);
            if ($receiver_contact->image_path === null) {
                $receiver_contact->image_path = asset($receiver_contact->receiver->avatar);
            }
            $receiver_contact->save();
            $contact->save();
        }
        return $contact;
    }

    public function getContactByReceiverId($id)
    {
        $contactByIdAndUser = Contact::where([['user_id', '=', Auth::id()], ['id', '=', $id]])->first();
        if ($contactByIdAndUser) {
            return response()->json(['data' => $contactByIdAndUser]);
        }
        return response()->json(null, 404);
    }

    public function storeAndPushMessage($request)
    {
        $message = $this->store($request);
        $attrs = ['sender_id', 'message', 'created_at', 'readed', 'image_path', 'contact_id'];
        $this->push($request->receiver_id, $message->only($attrs));
        return $message;
    }

    public function readContact($contact_id)
    {
        Contact::find($contact_id)->fill(['readed' => 1])->save();
    }

    public function newContact($request)
    {
        $receiver_id = $request->json()->all()['receiver_id'];
        $receiver = User::select('name', 'avatar')->where('id', $receiver_id)->first();
        $contact = Contact::where([['user_id', '=', Auth::id()], ['receiver_id', '=', $receiver_id]])->first();
        if (!$contact) {
            $contact = Contact::create(
                [
                    'user_id' => $request->user->id,
                    'receiver_id' => $receiver_id,
                    'receiver_name' => $receiver->name,
                    'image_path' => asset($receiver->avatar),
                    'readed' => 0
                ]
            );
        }
        return $contact;
    }

    public function getContactByUserAndReceiver($user_id, $receiver_id)
    {
        return Contact::where([['user_id', '=', $user_id], ['receiver_id', '=', $receiver_id]])
            ->first();
    }

    private function deleteAllMessageOfContact($contact_id)
    {
        $this->chatModel::where('contact_id', $contact_id)->delete();
    }

    public function destroyContact($id)
    {
        try {
            $contact = Contact::find($id);
            if (!$contact) {
                return response()->json(['message' => __('chatModel.contact_not_found')], 400);
            }
            $this->deleteAllMessageOfContact($id);
            $contact->delete();
            return response()->json(['message' => __('chatModel.delete_success')]);
        } catch (Exception $exception) {
            return response()->json(['message' => __('message.server_error')], 500);
        }
    }
}