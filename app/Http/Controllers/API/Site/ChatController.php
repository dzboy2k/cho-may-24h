<?php

namespace App\Http\Controllers\API\Site;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\Chat\ChatInterface;
use App\Repositories\Image\ImageInterface;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    private $chatRepo;
    private $imgRepo;
    private $upload_dir;
    private $root_dir;

    public function __construct(ChatInterface $chatRepo, ImageInterface $imgRepo)
    {
        $this->chatRepo = $chatRepo;
        $this->imgRepo = $imgRepo;
        $this->upload_dir = config('constants.CHAT_UPLOAD_DIR');
        $this->root_dir = config('constants.CHAT_ROOT_PATH');
    }

    public function send(Request $request)
    {
        try {
            if ($request->receiver_id == Auth::id()) {
                return response()->json(['message' => __('chat.can_send_to_self')], 500);
            }
            if ($request->hasFile('media')) {
                $image = $this->uploadImage($request->file('media'), '', $this->upload_dir, $this->root_dir, $this->imgRepo, 'chat-img');
                $request->media = $this->imgRepo->getById($image);
            }
            $request->contact = $this->chatRepo->firstOrNewContact($request);
            $message = $this->chatRepo->storeAndPushMessage($request);
            return response()->json($message);
        } catch (\Exception $exception) {
            return response()->json(['message' => __('message.server_error')], 500);
        }
    }

    public function getContactByUser($user_id)
    {
        return response()->json($this->chatRepo->getContactByUserId($user_id));
    }

    public function getContactById($contact_id)
    {
        if (!$contact_id) return response()->json(['message' => __('auth.user_not_found')], 404);
        return $this->chatRepo->getContactById($contact_id);
    }

    public function newContact(Request $request)
    {
        if ($request->receiver_id == Auth::id()) {
            return response()->json(['message' => __('chat.can_send_to_self')], 402);
        }
        return response()->json(['data' => $this->chatRepo->newContact($request)]);
    }

    public function getMessageByContact($contact_id)
    {
        return response()->json($this->chatRepo->getChatByUserAndReceiver($contact_id));
    }

    public function readContact($contact_id)
    {
        return $this->chatRepo->readContact($contact_id);
    }

    public function deleteContact($contact_id)
    {
        return $this->chatRepo->destroyContact($contact_id);
    }
}