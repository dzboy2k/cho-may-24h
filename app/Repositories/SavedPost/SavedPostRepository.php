<?php

namespace App\Repositories\SavedPost;

use App\Models\SavedPost;
use App\Http\Controllers\Controller;

class SavedPostRepository extends Controller implements SavedPostInterface
{
    private SavedPost $savedPost;
    public function __construct(SavedPost $savedPost)
    {
        $this->savedPost = $savedPost;
    }

    public function getListSavedPostsByUserID($id)
    {
        return $this->savedPost::where('user_id', $id)
            ->with(['post'])
            ->paginate(config('constants.AMOUNT_SAVED_POST'));
    }

    public function isSavedPostsByUserID($id)
    {
        return $this->savedPost::where('user_id', $id)->exists();
    }

    public function findSavedPost($userId, $postId)
    {
        return $this->savedPost::where([
            'user_id' => $userId,
            'post_id' => $postId
        ])->first();
    }

    public function savePost($userId, $postId)
    {
        return $this->savedPost::create([
            'user_id' => $userId,
            'post_id' => $postId
        ]);
    }

    public function unsavePost($userId, $postId)
    {
        return $this->savedPost::where([
            'user_id' => $userId,
            'post_id' => $postId
        ])->delete();
    }
}
