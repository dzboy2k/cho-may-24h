<?php

namespace App\Http\Controllers\API\Site;

use App\Http\Controllers\Controller;
use App\Repositories\Notification\NotificationRepositoryInterface;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private $notificationRepo;

    public function __construct(NotificationRepositoryInterface $notificationRepo)
    {
        $this->notificationRepo = $notificationRepo;
    }

    public function readNotification(Request $request)
    {
        $this->notificationRepo->update($request->json()->all());
    }

    public function getNotificationList(Request $request)
    {
        try {
            $userId = $request->user->id;
            $notificationList = $this->notificationRepo->get($userId);
            return response()->json($notificationList);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Get notification list failure',
            ], 500);
        }
    }

    public function createNotification(Request $request)
    {

        try {
            $notificationData = [
                'user_id' => $request->user_id,
                'content' => $request->notifi_content,
                'link' => $request->link,
                'image_path' => $request->image_path,
                'readed' => 0
            ];
            $this->notificationRepo->createAndPushNotificationForUser($notificationData);
            return response()->json([
                'message' => 'Create notification successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
