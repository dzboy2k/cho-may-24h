<?php

namespace App\Repositories\User;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\IDCards;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRepository extends Controller implements UserInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function findByReferralCode($referral_code)
    {
        return $this->user::where("referral_code", $referral_code)->first();
    }

    public function getListUserIdFollowing($id)
    {
        return Follow::where('followed_id', $id)->pluck('follower_id');
    }

    public function getListUserIdFollowed($id)
    {
        return Follow::where('follower_id', $id)->pluck('followed_id');
    }

    public function isFollowing($userId, $currentUserId)
    {
        $query_params = [['follower_id', $currentUserId], ['followed_id', $userId]];
        return Follow::where($query_params)
            ->exists();
    }

    public function followUser($followedId, $currentUserId)
    {
        if (!$this->isFollowing($followedId, $currentUserId)) {
            Follow::create([
                'follower_id' => $currentUserId,
                'followed_id' => $followedId,
            ]);
        } else {
            return response()->json(['message' => __('message.already_following')], 400);
        }
    }

    public function unfollowUser($userId, $currentUserId)
    {
        $query_params = [['follower_id', $currentUserId], ['followed_id', $userId]];
        Follow::where($query_params)
            ->delete();
    }

    public function update($user, $request)
    {
        $user->update($request);
    }

    public function saveIdCards($user, $request)
    {
        $dataIdCards = array_filter($request, function ($value) {
            return $value !== null;
        });
        if (!empty($dataIdCards)) {
            IDCards::updateOrCreate(['user_id' => $user->id], $dataIdCards);
        }
    }

    public function findById($id)
    {
        return $this->user::find($id);
    }

    public function changePassword($request)
    {
        try {
            $user = $this->user::find($request->id);
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => __('auth.old_password_incorrect')]);
            }
            if ($request->new_password != $request->new_password_confirmation) {
                return back()->withErrors(['password_confirmation' => __('user_info.confirm_password_incorrect')]);
            }
            if ($request->old_password === $request->new_password) {
                return back()->with('message', ['content' => __('auth.old_password_is_new_password'), 'type' => 'error']);
            }
            $user->fill(['password' => Hash::make($request->new_password)])->save();
            return redirect()->route('auth.logout')->with('message', ['content' => __('auth.change_password_success'), 'type' => 'success']);
        } catch (\Exception $exception) {
            return back()->with('message', ['content' => __('auth.change_password_failed'), 'type' => 'error']);
        }
    }

    public function existsUserById(mixed $receiver_id)
    {
        return $this->user::where('id', $receiver_id)->exists();
    }
}
