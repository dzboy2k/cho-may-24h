<?php

namespace App\Repositories\SavedPost;

interface SavedPostInterface
{
    public function getListSavedPostsByUserID($id);
    public function isSavedPostsByUserID($id);
    public function findSavedPost($userId, $postId);
    public function savePost($userId, $postId);
    public function unsavePost($userId, $postId);
}
