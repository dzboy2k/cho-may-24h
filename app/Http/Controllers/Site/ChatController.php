<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Repositories\Chat\ChatInterface;
use App\Repositories\Post\PostInterface;
use App\Repositories\User\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class ChatController extends Controller
{
    private $chatRepo;
    private $postRepo;
    private $userRepo;

    public function __construct(ChatInterface $chat, PostInterface $postRepo, UserInterface $user)
    {
        $this->chatRepo = $chat;
        $this->postRepo = $postRepo;
        $this->userRepo = $user;
    }

    public function showChatUI(Request $request)
    {
        try {
            if ($request->receiver_id) {
                $currentUserId = Auth::id();
                if ($request->receiver_id == $currentUserId) {
                    return redirect()->route('home')->with('message', ['content' => __('chat.can_not_send_to_self'), 'type' => 'error']);
                }
                $contact = $this->chatRepo->getContactByUserAndReceiver($currentUserId, $request->receiver_id);
                $receiver = $this->userRepo->findById($request->receiver_id);

                if (!$contact) {
                    if (!$receiver) {
                        return redirect()->route('home')->with('message', ['content' => __('chat.receiver_not_found'), 'type' => 'error']);
                    }
                    $contact = new Contact();
                    $contact->fill([
                        'receiver_id' => $request->receiver_id,
                        'user_id' => $currentUserId,
                        'receiver_name' => $receiver->name,
                        'image_path' => asset($receiver->avatar),
                        'receiver_referral_code'=>$receiver->referral_code,
                        'readed' => 0,
                    ]);
                }
                if ($request->post_id) {
                    $post = $this->postRepo->getPostByIdForChat($request->post_id);
                    $contact->save();
                    return view('site.chat.index', compact('post'));
                }
                return view('site.chat.index', compact('contact'));
            }
            return view('site.chat.index');
        } catch (Exception $exception) {
            abort(500);
        }
    }
}