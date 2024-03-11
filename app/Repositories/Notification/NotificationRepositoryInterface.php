<?php

namespace App\Repositories\Notification;

interface NotificationRepositoryInterface
{
    public function get($userId);

    public function getById($id);

    public function store($data);

    public function update($request);

    public function destroy($id);

    public function push($user_id, $notification);

    public function createAndPushNotificationForUser($data);

    public function createAndPushNotificationForUsers($user_ids, $message);
}
