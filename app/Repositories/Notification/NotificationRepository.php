<?php

namespace App\Repositories\Notification;

use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationRepository extends Controller implements NotificationRepositoryInterface
{
    private Notification $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function get($userId)
    {
        return $this->notification::where('user_id', $userId)
            ->orderBy('readed', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(config('constants.NOTIFICATION_PER_PAGE'));
    }

    public function getById($id)
    {
        return $this->notification::find($id);
    }

    public function store($data)
    {
        return $this->notification::create($data);
    }

    public function update($request)
    {
        $notification = $this->notification::find($request['id']);
        $notification->fill($request);
        $notification->save();
    }

    public function destroy($id)
    {
        $this->notification::find($id)->delete();
    }

    public function push($user_id, $notification)
    {
        event(new NotificationEvent($user_id, $notification));
    }

    public function createAndPushNotificationForUser($data)
    {
        $notification = $this->store($data);
        $data['created_at'] = $notification->created_at;
        $this->push($data['user_id'], $data);
    }

    public function createAndPushNotificationForUsers($user_ids, $message)
    {
        foreach ($user_ids as $id) {
            $notificationData['user_id'] = $id;
            $this->createAndPushNotificationForUser($notificationData);
        }
    }
}
