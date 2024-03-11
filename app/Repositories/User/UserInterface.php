<?php

namespace App\Repositories\User;

interface UserInterface
{
    public function findByReferralCode($code);

    public function getListUserIdFollowing($id);

    public function getListUserIdFollowed($id);

    public function isFollowing($userId, $currentUserId);

    public function followUser($followedId, $currentUserId);

    public function unfollowUser($userId, $currentUserId);

    public function update($user, $request);

    public function saveIdCards($user, $request);

    public function findById($id);

    public function changePassword($request);

    public function existsUserById(mixed $receiver_id);
}
