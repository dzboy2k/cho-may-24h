<?php

namespace App\Http\Controllers\API\Site;

use App\Http\Controllers\Controller;
use App\Repositories\SavedPost\SavedPostRepository;
use Illuminate\Support\Facades\Auth;

class SavedPostController extends Controller
{
    private $savedPostRepo;

    public function __construct(SavedPostRepository $savedPostRepo)
    {
        $this->savedPostRepo = $savedPostRepo;
    }

    public function toggleSave($postId)
    {
        try {
            $userId = Auth::id();
            $savedPost = $this->savedPostRepo->findSavedPost($userId, $postId);
            if ($savedPost) {
                $this->savedPostRepo->unsavePost($userId, $postId);
                $message = __('message.unsave_post_success');
                $isSavedPost = false;
            } else {
                $this->savedPostRepo->savePost($userId, $postId);
                $message = __('message.save_post_success');
                $isSavedPost = true;
            }
            return response()->json(['message' => $message, 'isSavedPost' => $isSavedPost]);
        } catch (\Exception $e) {
            return response()->json(['message' => __('message.server_error')], 500);
        }
    }
}
